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
        $paynow = new Paynow(config('app.PAYNOW_INTEGRATION_ID'), config('app.PAYNOW_INTEGRATION_KEY'), config('app.PAYNOW_RETURN_URL'), config('app.PAYNOW_RESULT_URL'));

        $payment = $paynow->createPayment($eventName, $paymentModel->payerEmail);

        foreach ($order->items as $item) {
            $ticket = Ticket::query()->firstWhere('id', $item->ticket_id);
            $billPrice = $ticket->price * $item->quantity;
            $payment->add($ticket->eventName . " " . $ticket->ticketType->name, $billPrice);
        }

//        return $paynow->sendMobile($payment, $paymentModel->payerMobile, $paymentModel->paymentMode);
        return $paynow->sendMobile($payment, $paymentModel->payerMobile, $paymentModel->paymentMode);
    }

    /**
     * @throws ConnectionException
     * @throws HashMismatchException
     */
    public function pollPayNowResponse($pollUrl, Payments $payment): bool
    {
        $paynow = new Paynow(config('app.PAYNOW_INTEGRATION_ID'), config('app.PAYNOW_INTEGRATION_KEY'), config('app.PAYNOW_RETURN_URL'), config('app.PAYNOW_RESULT_URL'));

        $status = $paynow->pollTransaction($pollUrl);

        Log::info("====== Status is ======", [$status]);
        Log::info("====== Status Data is ======", [$status->data()]);

        if ($status->paid()) {
            $payment->update([
                'status' => 'Paid',
                'pollUrl' => $pollUrl,
                'message' => 'Payment Was Successful'
            ]);
            return true;
        } else {
            $payment->update([
                'pollUrl' => $pollUrl,
                'status' => $status->status(),
                'message' => $status->data()['error']
            ]);
            return false;
        }
    }

}
