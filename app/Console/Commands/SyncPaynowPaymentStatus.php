<?php

namespace App\Console\Commands;

use App\Models\Payments;
use App\PayNowTrait;
use Illuminate\Console\Command;

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
                ->orWhere('status','=','Sent')
                ->get();
            foreach ($payments as $payment) {
                $this->pollPayNowResponse($payment->pollUrl, $payment);
            }
            $this->info('======= Payment Synchronization Completed =======');
        } catch (\Exception $ex) {
            $this->info('======= Error Occurred During Payment Synchronization =======');
            $this->info($ex->getMessage());
        }

    }
}
