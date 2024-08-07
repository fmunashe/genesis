<?php

namespace App\Notifications;

use App\Models\QRcode;
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
    public function __construct()
    {
        //
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
            $code = random_int(10000000000, 999999999999);
            $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(200)->encoding('UTF-8')->generate($code);
            $qrCodeBase64 = base64_encode($qrCode);
            QRcode::query()->create([
                'code' => $code
            ]);

            \SimpleSoftwareIO\QrCode\Facades\QrCode::email('farai@gmail.com','Testing',$qrCode);
            return (new MailMessage)
                ->subject('Event Admission Ticket')
                ->greeting('Greetings Music Lover!!')
                ->line('Thank you for purchasing a ticket to our event!')
                ->line('Below is your code that you must bring on the day of the event')
                ->line($code)
//                ->line('<img src="data:image/png;base64,' . $qrCodeBase64 . '">')
//                <img src="{!!$message->embedData(QrCode::format('png')->size(200)->encoding('UTF-8')->generate($data['qr']), 'QrCode.png', 'image/png')!!}">
                ->line("Note that without this you will not be admitted at the gate")
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
}
