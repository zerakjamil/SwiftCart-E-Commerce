<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class DiscountService
{
    public function calculateDiscount(): void
    {
        Log::info('Calculating discount...');

        if (!Session::has('coupon')) {
            Log::info('No coupon in session, updating cart totals');
            $this->updateCartTotals();
            return;
        }

        $coupon = Session::get('coupon');
        Log::info('Coupon from session:', ['coupon' => $coupon]);

        $cartSubtotal = $this->getCartSubtotal();
        Log::info('Cart subtotal:', ['subtotal' => $cartSubtotal]);

        if (!is_array($coupon) || !isset($coupon['type']) || !isset($coupon['value'])) {
            Log::warning('Invalid coupon data, removing coupon and updating cart totals');
            Session::forget('coupon');
            $this->updateCartTotals();
            return;
        }

        $discount = $this->calculateCouponDiscount($coupon, $cartSubtotal);
        Log::info('Calculated discount:', ['discount' => $discount]);

        $subtotalAfterDiscount = max(0, $cartSubtotal - $discount);
        $tax = $this->calculateTax($subtotalAfterDiscount);
        $total = $subtotalAfterDiscount + $tax;

        Log::info('Final calculations:', [
            'subtotalAfterDiscount' => $subtotalAfterDiscount,
            'tax' => $tax,
            'total' => $total
        ]);

        $this->storeDiscountsInSession($discount, $subtotalAfterDiscount, $tax, $total);
    }

    public function removeDiscount(): void
    {
        Session::forget('coupon');
        Session::forget('discounts');
        $this->updateCartTotals();
    }

    public function dismissCouponOnCartClear(): void
    {
        if (Cart::instance('cart')->count() == 0) {
            $this->removeDiscount();
        }
    }

    public function updateCartTotals(): void
    {
        $cartSubtotal = $this->getCartSubtotal();
        $tax = $this->calculateTax($cartSubtotal);
        $total = $cartSubtotal + $tax;

        $this->storeDiscountsInSession(0, $cartSubtotal, $tax, $total);
    }

    private function getCartSubtotal(): float
    {
        return floatval(Cart::instance('cart')->subtotal(2, '.', ''));
    }

    private function calculateCouponDiscount($coupon, $cartSubtotal)
    {
        if ($coupon['type'] === 'fixed') {
            return min($coupon['value'], $cartSubtotal);
        } elseif ($coupon['type'] === 'percent') {
            return $cartSubtotal * (floatval($coupon['value']) / 100);
        }
        return 0;
    }

    private function calculateTax($subtotal): float|int
    {
        return $subtotal * (config('cart.tax') / 100);
    }

    private function storeDiscountsInSession($discount, $subtotal, $tax, $total): void
    {
        Session::put('discounts', [
            'discount' => $this->formatCurrency($discount),
            'subtotal' => $this->formatCurrency($subtotal),
            'tax' => $this->formatCurrency($tax),
            'total' => $this->formatCurrency($total),
        ]);
    }

    private function formatCurrency($value): string
    {
        return number_format(floatval($value), 2, '.', '');
    }
}
