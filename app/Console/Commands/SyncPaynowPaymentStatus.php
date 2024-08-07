<?php

namespace App\Console\Commands;

use App\Models\Payments;
use App\Models\TempUser;
use App\Notifications\SendTicketsNotification;
use App\PayNowTrait;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class SyncPaynowPaymentStatus extends Command
{
    use PayNowTrait;

    protected $signature = 'paynow:sync';

    protected $description = 'Command to sync paynow payment statuses';

    public function handle(): void
    {
        try {
            $this->info('======= Initiate Payment Synchronization =======');
            $payments = Payments::query()
                ->whereNull(['status'])
                ->orWhere('status', '=', '')
                ->orWhere('status', '=', 'Sent')
                ->get();
            foreach ($payments as $payment) {
                $status = $this->pollPayNowResponse($payment->pollUrl, $payment);
                if ($status) {
                    $codesToGenerate = $payment->order->items->sum('quantity');
                    Log::info("code to generate are ", [$codesToGenerate]);
                    $tempUser = new TempUser($payment->payerEmail);
                    Notification::send($tempUser, new SendTicketsNotification());
                }
            }
            $this->info('======= Payment Synchronization Completed =======');
        } catch (\Exception $ex) {
            $this->info('======= Error Occurred During Payment Synchronization =======');
            Log::info($ex->getMessage());
        }

    }
}
