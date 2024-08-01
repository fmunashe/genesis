<?php

namespace App;

use App\Models\Order;
use App\Models\Payments;
use App\Models\Ticket;
use Illuminate\Support\Facades\Log;
use Paynow\Core\InitResponse;
use Paynow\Http\ConnectionException;
use Paynow\Payments\HashMismatchException;
use Paynow\Payments\InvalidIntegrationException;
use Paynow\Payments\NotImplementedException;
use Paynow\Payments\Paynow;

trait PayNowTrait
{
    /**
     * @throws HashMismatchException
     * @throws InvalidIntegrationException
     * @throws NotImplementedException
     * @throws ConnectionException
     */
    public function initiatePayNowRequest($eventName, Payments $paymentModel, Order $order): InitResponse
    {
        $paynow = new Paynow('INTEGRATION_ID', 'INTEGRATION_KEY', 'http://example.com/gateways/paynow/update', 'http://example.com/return?gateway=paynow');

        $payment = $paynow->createPayment($eventName, $paymentModel->payerEmail);

        foreach ($order->items as $item) {
            $ticket = Ticket::query()->firstWhere('id', $item->ticket_id);
            $billPrice = $ticket->price * $item->quantity;
            $payment->add($ticket->eventName . " " . $ticket->ticketType->name, $billPrice);
        }

        return $paynow->sendMobile($payment, $paymentModel->payerMobile, $paymentModel->paymentMode);
    }

    /**
     * @throws ConnectionException
     * @throws HashMismatchException
     */
    public function pollPayNowResponse($pollUrl, Payments $payment): bool
    {
        $paynow = new Paynow('INTEGRATION_ID', 'INTEGRATION_KEY', 'http://example.com/gateways/paynow/update', 'http://example.com/return?gateway=paynow');

        $status = $paynow->pollTransaction($pollUrl);

        if ($status->paid()) {
            $payment->update([
                'status' => 'Paid',
                'pollUrl' => $pollUrl
            ]);
            return true;
        } else {
            $payment->update([
                'pollUrl' => $pollUrl
            ]);
            return false;
        }
    }

}