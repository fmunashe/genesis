<?php

namespace App\Notifications;

use App\Models\Payments;
use App\Models\QRcode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Random\RandomException;

class SendTicketsNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public int $totalCodes;
    public Payments $payment;

    public function __construct($codes, $payment)
    {
        $this->totalCodes = $codes;
        $this->payment = $payment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        try {
            $codesArray = [];
            foreach ($this->payment->order->items as $item) {
                for ($i = 0; $i < $item->quantity; $i++) {
                    $code = random_int(10000000000, 999999999999);
                    QRcode::query()->create([
                        'code' => $code
                    ]);
                    $codesArray['codes'][] = $this->generateQrCode($code);
                    $codesArray['tickets'][] = $item->ticket;
                }
            }
            $pdf = $this->generatePdfWithQrCode($codesArray, $this->payment);

            return (new MailMessage)
                ->subject('Event Admission Ticket')
                ->greeting('Greetings Music Lover!!')
                ->line('Thank you for purchasing tickets to our event!')
                ->line('Check the attached document with QR codes containing details of your purchase')
                ->line("Note that without this you will not be admitted at the gate")
                ->attachData($pdf, 'ticketInformation.pdf', [
                    'mime' => 'application/pdf',
                ])
                ->line('Thank you for supporting us!');

        } catch (RandomException $e) {
            return new MailMessage();
        }
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    protected function generatePdfWithQrCode($codes, $payment): string
    {
        $orderItem = $payment->order->items->first();
        $ticket = $orderItem->ticket;
        $pdf = Pdf::loadView('notification', ['codes' => $codes, 'ticket' => $ticket]);

        return $pdf->output();
    }

    protected function generateQrCode($code): string
    {
        return base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(100)->generate($code));
    }
}
