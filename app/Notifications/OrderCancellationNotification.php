<?php

namespace App\Notifications;

use App\Models\Admin\V1\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCancellationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     *
     * @param Order $order
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Order Has Been Canceled')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your order #' . $this->order->id . ' has been canceled.')
            ->line('If you did not request this cancellation, please contact our customer support.')
            ->line('If a payment was made, a refund will be processed within 3-5 business days.')
            ->action('View Order Details', route('user.orders.details', ['order' => $this->order->id]))
            ->line('Thank you for shopping with us!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'message' => 'Your order #' . $this->order->id . ' has been canceled.',
            'action_url' => route('user.orders.details', ['order' => $this->order->id])
        ];
    }
}
