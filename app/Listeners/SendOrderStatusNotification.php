<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\OrderStatusChanged;

class SendOrderStatusNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function __construct()
    {
        //
    }

    public function handle(OrderStatusUpdated $event)
    {
        $order = $event->order;
        $customer = $order->customer;

        $customer->notify(new OrderStatusChanged($order));
    }

    public function failed(OrderStatusUpdated $event, $exception)
    {
        // Log the failure or take other actions
        \Log::error('Failed to send order status notification', [
            'order_id' => $event->order->id,
            'error' => $exception->getMessage()
        ]);
    }
}
