<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Booking;

class OrderStatusChanged extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Booking $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $statusMessages = [
            'confirmed' => 'Your order has been accepted by the laundress.',
            'processing' => 'Your order is now being processed.',
            'completed' => 'Your order has been completed.',
            'cancelled' => 'Your order has been cancelled.'
        ];

        return (new MailMessage)
            ->from(config('mail.from.address'), config('mail.from.name'))
            ->subject("Order #{$this->order->id} Status Update")
            ->greeting("Hello {$notifiable->name}!")
            ->line($statusMessages[$this->order->status] ?? 'Your order status has been updated.')
            ->line("Order ID: #{$this->order->id}")
            ->line("Current Status: " . ucfirst($this->order->status))
            ->action('View Order Details', route('customer.orders.show', $this->order))
            ->line('Thank you for using our service!');
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'status' => $this->order->status,
            'message' => "Order #{$this->order->id} has been " . $this->order->status
        ];
    }
}