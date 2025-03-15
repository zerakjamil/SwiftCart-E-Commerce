<?php

namespace App\Http\Services;

use App\Models\Admin\V1\{Address, Admin, Order, OrderItem, Product, Transaction};
use App\Notifications\AdminOrderCancellationNotification;
use App\Notifications\OrderCancellationNotification;
use Illuminate\Support\Facades\{Auth, DB, Log, Session};
use Illuminate\Database\Eloquent\Model;
use Surfsidemedia\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Carbon\Carbon;

class OrderService extends Service
{
    protected CheckoutService $checkoutService;
    public function __construct(Order $order, CheckoutService $checkoutService)
    {
        parent::__construct($order);
        $this->checkoutService = $checkoutService;
    }

    /**
     * Create a new order
     *
     * @param Address $address
     * @return Order
     */
    public function createOrder(Address $address): Order
    {
        $order = new Order();
        $order->user_id = Auth::id();

        $order->subtotal = $this->checkoutService->formatCartValue(Session::get('checkout')['subtotal']);
        $order->discount = $this->checkoutService->formatCartValue(Session::get('checkout')['discount']);
        $order->tax = $this->checkoutService->formatCartValue(Session::get('checkout')['tax']);
        $order->total = $this->checkoutService->formatCartValue(Session::get('checkout')['total']);

        $order->billing_name = $address->name;
        $order->billing_phone = $address->phone;
        $order->address_id = $address->id;

        $order->save();

        return $order;
    }

    /**
     * Create order items from cart
     *
     * @param string $orderId
     */
    public function createOrderItems(string $orderId): void
    {
        foreach (Cart::instance('cart')->content() as $item) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $orderId;
            $orderItem->product_id = $item->id;
            $orderItem->price = $item->price;
            $orderItem->quantity = $item->qty;
            $orderItem->save();
        }
    }

    /**
     * Update order status and related transaction if needed
     *
     * @param Order $order
     * @param string $status
     * @return bool
     */
    public function updateOrderStatus(Order $order, string $status): bool
    {
        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'canceled'];
        if (!in_array($status, $validStatuses)) {
            return false;
        }

        $order->status = $status;

        switch ($status) {
            case 'delivered':
                $order->delivered_at = Carbon::now();
                break;
            case 'canceled':
                $order->canceled_at = Carbon::now();
                break;
        }

        $saved = $order->save();

        if ($saved && $status === 'delivered') {
            $this->updateRelatedTransaction($order->id);
        }

        return $saved;
    }

    /**
     * Update transaction status to approved when order is delivered
     *
     * @param string $orderId
     * @return bool
     */
    private function updateRelatedTransaction(string $orderId): bool
    {
        $transaction = Transaction::where('order_id', $orderId)->first();

        if ($transaction) {
            $transaction->status = 'approved';
            return $transaction->save();
        }

        return false;
    }

    /**
     * Cancel an order and handle related operations
     *
     * @param Order $order
     * @return bool
     */
    public function cancelOrder(Order $order): bool
    {
        try {
            DB::beginTransaction();

            $order->status = 'canceled';
            $order->canceled_at = Carbon::now();
            $order->save();

            $this->returnItemsToInventory($order);

            $this->processRefundIfNeeded($order);

            $this->sendCancellationNotification($order);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order cancellation failed: ' . $e->getMessage());
            return false;
        }
    }

    private function returnItemsToInventory(Order $order): void
    {
        $orderItems = OrderItem::where('order_id', $order->id)->get();

        foreach ($orderItems as $item) {
            $product = Product::find($item->product_id);
            if ($product) {
                $product->quantity += $item->quantity;
                $product->save();

                Log::info("Inventory updated: {$item->quantity} units of product ID {$product->id} returned to stock due to order cancellation");
            }
        }
    }

    /**
     * Process refund for paid orders
     *
     * @param Order $order
     * @return void
     */
    private function processRefundIfNeeded(Order $order): void
    {
        $transaction = Transaction::where('order_id', $order->id)->first();

        if ($transaction && $transaction->status === 'approved') {
            $transaction->status = 'refunded';
            $transaction->save();

            // Here you would integrate with your payment gateway to process actual refund
            // $stripeService = new StripeService();
            // $stripeService->processRefund($transaction->transaction_id);

            Log::info("Refund processed for order ID {$order->id}, transaction ID {$transaction->id}");
        }
    }

    /**
     * Send order cancellation notification
     *
     * @param Order $order
     * @return void
     */
    private function sendCancellationNotification(Order $order): void
    {
        $user = $order->user;
        if ($user) {
            $user->notify(new OrderCancellationNotification($order));
            Log::info("Cancellation notification sent to user ID {$user->id} for order ID {$order->id}");
        }

        $this->notifyAdminsAboutCancellation($order);
    }

    /**
     * Notify admins and stakeholders about order cancellation
     *
     * @param Order $order
     * @return void
     */
    private function notifyAdminsAboutCancellation(Order $order): void
    {
        $admins = Admin::role(['admin', 'superadmin'])
            ->get();

        foreach ($admins as $admin) {
            $admin->notify(new AdminOrderCancellationNotification($order));
            Log::info("Order cancellation notification sent to admin ID {$admin->id} for order ID {$order->id}");
        }
    }
}
