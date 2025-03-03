<?php

namespace App\Http\Services;

use App\Models\Admin\V1\Address;
use Illuminate\Support\Facades\Auth;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CheckoutService
{
    public function validateCart(): array
    {
        if (Cart::instance('cart')->count() == 0) {
            return [
                'valid' => false,
                'message' => 'Your cart is empty'
            ];
        }

        return ['valid' => true];
    }

    public function validateAddress(): array
    {
        $address = Address::where('user_id', Auth::id())
                          ->where('is_default', 1)
                          ->first();

        if (!$address) {
            return [
                'valid' => false,
                'message' => 'Please add a default address before checkout'
            ];
        }

        return [
            'valid' => true,
            'address' => $address
        ];
    }
}
