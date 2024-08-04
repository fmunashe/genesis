<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentsRequest;
use App\Http\Requests\UpdatePaymentsRequest;
use App\Models\Order;
use App\Models\OrderItems;
use App\Models\Payments;
use App\Models\Ticket;
use App\PayNowTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Paynow\Http\ConnectionException;
use Paynow\Payments\HashMismatchException;
use Paynow\Payments\InvalidIntegrationException;
use Paynow\Payments\NotImplementedException;

class PaymentsController extends BaseController
{
    use PayNowTrait;

    public function index(): JsonResponse
    {
        $payments = Payments::query()->with(['order', 'order.items'])->latest()->paginate(10);
        return $this->buildSuccessResponse($payments, "payments retrieved successfully");
    }


    public function store(StorePaymentsRequest $request): JsonResponse
    {
        $data = $request->all();
        $eventName = null;
        $order = Order::query()->create([
            'description' => 'New Event Order'
        ]);


        foreach ($data['tickets'] as $ticketId) {
            OrderItems::query()->create([
                'order_id' => $order->id,
                'ticket_id' => $ticketId['ticket_id'],
                'quantity' => $ticketId['quantity']
            ]);
        }

        $totalBill = 0;
        foreach ($order->items as $item) {
            $ticket = Ticket::query()->firstWhere('id', '=', $item->ticket_id);
            $totalBill = $totalBill + ($ticket->price * $item->quantity);
            $eventName = $ticket->eventName;
        }
        $payment = Payments::query()->create([
            'order_id' => $order->id,
            'payerEmail' => $data['payerEmail'],
            'payerMobile' => $data['payerMobile'],
            'paymentMode' => $data['paymentMode'],
            'totalBill' => $totalBill
        ]);

        try {
            $response = $this->initiatePayNowRequest($eventName, $payment, $order);
            if ($response->success()) {
                $status = $this->pollPayNowResponse($response->pollUrl(), $payment);
                $paymentResponse = Payments::query()->firstWhere('id', '=', $payment->id);
                if ($status) {
                    return $this->buildSuccessResponse($paymentResponse, "Payment has successfully been processed");
                }
                return $this->buildSuccessResponse($paymentResponse, "Payment is being processed");
            } else {
                return $this->buildErrorResponse("Payment processing failed please try again", null, 400);
            }
        } catch (ConnectionException|HashMismatchException|InvalidIntegrationException|NotImplementedException $e) {
            Log::info("error from paynow ", [$e->getMessage()]);
            return $this->buildErrorResponse($e->getMessage(), null, 400);
        }
    }

    public function show(Payments $payments): JsonResponse
    {
        return $this->buildSuccessResponse($payments,"Payment record retrieved successfully");
    }


    public function pollTransaction()
    {
        $this->pollPayNowResponse();
    }
}
