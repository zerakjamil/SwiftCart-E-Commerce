<?php

namespace App\Http\Services;

use App\Models\Admin\V1\{Address,Transaction};
use App\Http\Requests\V1\OrderRequests\StoreOrderRequest;
use Illuminate\Support\Facades\{Auth,Session};
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CheckoutService extends Service
{
    public function __construct(Address $address)
    {
        parent::__construct($address);
    }
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
                'message' => 'Please add a default shipping address before proceeding to checkout.'
            ];
        }

        $requiredFields = ['name','phone','locality','address','city','state','country','zip','landmark'];
        foreach ($requiredFields as $field) {
            if (empty($address->$field)) {
                return [
                    'valid' => false,
                    'message' => "Your default address is missing the {$field}. Please update your address."
                ];
            }
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
    public function getUserDefaultAddress(): ?Address
    {
        if (Auth::check()) {
            $address = Auth::user()->addresses()->where('is_default', true)->first();

            if (!$address) {
                $address = Auth::user()->addresses()->first();
            }

            return $address;
        }

        return null;
    }

    /**
     * Get existing address or create a new one
     *
     * @param array $addressData
     * @return Address
     */
    public function createAddress(array $addressData): Address
    {
            $address = new Address();
            $address->fillAttributes($addressData);
            $address->user_id = Auth::id();
            $address->country = 'kurdistan';
            $address->is_default = true;
            $address->save();

        return $address;
    }

    public function getAddress(StoreOrderRequest $request): ?Address
    {
        if (!$request['use_existing_address']) {
            $address = $this->createAddress($request->validated());
            if (!$address) {
                throw new \Exception('No default address found.');
            }
        } else {
            $address = $this->getUserDefaultAddress();
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
     * Format a cart value by removing commas and converting to float
     *
     * @param string|float $value
     * @return float
     */
    public function formatCartValue($value): float
    {
        if (is_string($value)) {
            return (float)str_replace(',', '', $value);
        }

        return (float)$value;
    }

    /**
     * Process payment transaction
     *
     * @param string $paymentMode
     * @param string $orderId
     */
    public function processPayment(string $paymentMode, string $orderId): void
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
     * @param string $orderId
     * @param string $mode
     * @param string $status
     * @return Transaction
     */
    private function createTransaction(string $orderId, string $mode, string $status): Transaction
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
