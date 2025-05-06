<?php

namespace App\Listeners;

use App\Events\CustomerPasswordChanged;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CustomerPasswordChangeNotification;

class NotifyAdminOfPasswordChange
{
    /**
     * Handle the event.
     */
    public function handle(CustomerPasswordChanged $event): void
    {
        // Only notify admin users (role_id = 1)
        $admins = User::where('role_id', 1)->get();
        
        if ($admins->isNotEmpty()) {
            Notification::send($admins, new CustomerPasswordChangeNotification($event->user));
        }
    }
}