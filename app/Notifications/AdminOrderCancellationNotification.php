<?php

namespace App\Notifications;

use App\Models\Admin\V1\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminOrderCancellationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Order #' . $this->order->id . ' Has Been Cancelled')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('An order has been cancelled.')
            ->line('Order ID: #' . $this->order->id)
            ->line('Customer: ' . ($this->order->user ? $this->order->user->name : 'Guest'))
            ->line('Total Amount: $' . number_format($this->order->total, 2))
            ->line('Cancelled at: ' . $this->order->canceled_at->format('Y-m-d H:i:s'))
            ->action('View Order Details', route('admin.orders.show', $this->order->id))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'user_id' => $this->order->user_id,
            'total' => $this->order->total,
            'canceled_at' => $this->order->canceled_at,
            'message' => 'Order #' . $this->order->id . ' has been cancelled'
        ];
    }
}
