<?php

namespace App\Http\Services;

use App\Models\Admin\V1\{Address,Order,OrderItem,Transaction};
use Illuminate\Support\Facades\{Auth,Session};
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
}
