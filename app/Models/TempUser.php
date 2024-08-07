<?php

namespace App\Models;

use Illuminate\Support\Facades\Notification;

class TempUser
{
    protected $email;

    public function __construct($email)
    {
        $this->email = $email;
    }

    public function routeNotificationFor($notification)
    {
        return $this->email;
    }

    public function notify(Notification $notification): null
    {
        return Notification::send($this, $notification);
    }
}
