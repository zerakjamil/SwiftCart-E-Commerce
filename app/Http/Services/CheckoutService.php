<?php

namespace App\Http\Services;

use App\Models\Admin\V1\{Address,Order,OrderItem,Transaction};
use Illuminate\Support\Facades\{Auth,Session};
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CheckoutService
{
    /**
     * Validate the cart contents
     *
     * @return array
     */
    public function validateCart(): array
    {
        if (Cart::instance('cart')->count() <= 0) {
            return [
                'valid' => false,
                'message' => 'Your cart is empty!'
            ];
        }

        return [
            'valid' => true
        ];
    }

    /**
     * Validate user address
     *
     * @return array
     */
    public function validateAddress(): array
    {
        $address = $this->getUserDefaultAddress();

        if (!$address) {
            return [
                'valid' => false,
                'message' => 'Please add a default address before checkout.'
            ];
        }

        return [
            'valid' => true,
            'address' => $address
        ];
    }

    /**
     * Get user's default address
     *
     * @return Address|null
     */
    public function getUserDefaultAddress()
    {
        return Address::where('user_id', Auth::id())
            ->where('is_default', true)
            ->first();
    }

    /**
     * Get existing address or create a new one
     *
     * @param array $addressData
     * @return Address
     */
    public function getOrCreateAddress(array $addressData): Address
    {
        $address = $this->getUserDefaultAddress();

        if (!$address) {
            $address = new Address();
            $address->fillAttributes($addressData);
            $address->user_id = Auth::id();
            $address->country = 'kurdistan';
            $address->is_default = true;
            $address->save();
        }

        return $address;
    }

    /**
     * Set checkout amounts in session
     */
    public function setCheckoutAmounts(): void
    {
        if (!Cart::instance('cart')->content()->count() > 0) {
            Session::forget('checkout');
            return;
        }

        if (Session::has('coupon')) {
            Session::put('checkout', [
                'discount' => Session::get('discounts')['discount'],
                'subtotal' => Session::get('discounts')['subtotal'],
                'tax' => Session::get('discounts')['tax'],
                'total' => Session::get('discounts')['total'],
            ]);
        } else {
            Session::put('checkout', [
                'discount' => 0,
                'subtotal' => Cart::instance('cart')->subtotal(),
                'tax' => Cart::instance('cart')->tax(),
                'total' => Cart::instance('cart')->total(),
            ]);
        }
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

        $order->subtotal = Session::get('checkout')['subtotal'];
        $order->discount = Session::get('checkout')['discount'];
        $order->tax = Session::get('checkout')['tax'];
        $order->total = Session::get('checkout')['total'];

        $order->billing_name = $address->name;
        $order->billing_phone = $address->phone;
        $order->address_id = $address->id;

        $order->save();

        return $order;
    }

    /**
     * Create order items from cart
     *
     * @param int $orderId
     */
    public function createOrderItems(int $orderId): void
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
     * Process payment transaction
     *
     * @param string $paymentMode
     * @param int $orderId
     */
    public function processPayment(string $paymentMode, int $orderId): void
    {
        switch ($paymentMode) {
            case 'cash':
                $this->createTransaction($orderId, 'cod', 'pending');
                break;
            case 'card':
                $this->createTransaction($orderId, 'card', 'pending');
                break;
            case 'paypal':
                $this->createTransaction($orderId, 'paypal', 'pending');
                break;
        }
    }

    /**
     * Create a transaction record
     *
     * @param int $orderId
     * @param string $mode
     * @param string $status
     * @return Transaction
     */
    private function createTransaction(int $orderId, string $mode, string $status): Transaction
    {
        $transaction = new Transaction();
        $transaction->user_id = Auth::id();
        $transaction->order_id = $orderId;
        $transaction->mode = $mode;
        $transaction->status = $status;
        $transaction->save();

        return $transaction;
    }

    /**
     * Clear cart and session data
     */
    public function clearCartAndSession(): void
    {
        Cart::instance('cart')->destroy();
        Session::forget('checkout');
        Session::forget('coupon');
        Session::forget('discounts');
    }
}
