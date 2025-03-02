<?php

namespace App\Http\Controllers;

use App\Http\Services\{CouponService, DiscountService};
use App\Models\Admin\V1\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    protected CouponService $couponService;
    protected DiscountService $discountService;

    public function __construct(CouponService $couponService, DiscountService $discountService)
    {
        $this->couponService = $couponService;
        $this->discountService = $discountService;
    }

    public function index(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $items = Cart::instance('cart')->content();
        $suggested_products = Product::inRandomOrder()->limit(4)->get();
        return view('guest.cart.index', compact('items', 'suggested_products'));
    }

    public function add(Request $request): \Illuminate\Http\RedirectResponse
    {
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price)
            ->associate(Product::class);
        $this->discountService->calculateDiscount();
        return $this->respondSuccess('Product added to cart successfully');
    }

    public function increment($rowId): \Illuminate\Http\RedirectResponse
    {
        return $this->updateCartItemQuantity($rowId, 1);
    }

    public function decrement($rowId): \Illuminate\Http\RedirectResponse
    {
        return $this->updateCartItemQuantity($rowId, -1);
    }

    public function remove($rowId): \Illuminate\Http\RedirectResponse
    {
        try {
            Cart::instance('cart')->remove($rowId);
            $this->discountService->removeDiscount();
            return $this->respondSuccess('Item removed from cart');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error removing cart item');
        }
    }

    public function clear(): \Illuminate\Http\RedirectResponse
    {
        try {
            Cart::instance('cart')->destroy();
            $this->discountService->dismissCouponOnCartClear();
            return $this->respondSuccess('Cart cleared successfully');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error clearing cart');
        }
    }

    public function applyCouponCode(Request $request): \Illuminate\Http\RedirectResponse
    {
        if ($request->coupon_code === null){
            return redirect()->back()->withError('Coupon code is required');
        }
        $result = $this->couponService->applyCoupon($request->coupon_code);
        return $result['success']
            ? $this->respondSuccess($result['message'])
            : $this->respondError($result['message']);
    }

    public function removeCouponCode()
    {
        try {
            $this->discountService->removeDiscount();
            return redirect()->route('cart.index')->withSuccess('Coupon removed successfully.');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Coupon remove was unsuccessful');
        }
    }

    private function updateCartItemQuantity($rowId, $change): \Illuminate\Http\RedirectResponse
    {
        try {
            $cart = Cart::instance('cart');
            $item = $cart->get($rowId);

            if (!$item) {
                return $this->respondError('Item not found in cart');
            }
            $cart->update($rowId, $item->qty + $change);
            $this->discountService->updateCartTotals();
            return $this->respondSuccess('Item quantity updated');
        } catch (\Exception $e) {
            return $this->handleException($e, 'Error updating cart item');
        }
    }

    private function respondSuccess($message): \Illuminate\Http\RedirectResponse
    {
        return redirect()->back()->withSuccess($message);
    }

    private function respondError($message): \Illuminate\Http\RedirectResponse
    {
        return redirect()->back()->withError($message);
    }

    private function handleException(\Exception $e, $message): \Illuminate\Http\RedirectResponse
    {
        Log::error($message . ': ' . $e->getMessage());
        return $this->respondError('An error occurred. Please try again.');
    }
}
