<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerPasswordChangeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $customer;

    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        return [
            'title' => 'Password Changed',
            'message' => 'has updated their password',
            'user_id' => $this->customer->id,
            'user_name' => $this->customer->name,
            'user_avatar' => $this->customer->avatar, // Direct assignment without null coalescing
            'type' => 'password_change',
            'time' => now()->toDateTimeString()
        ];
    }
}