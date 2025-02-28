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
        return view('guest.cart.index', compact('items','suggested_products'));
    }

    public function add(Request $request)
    {
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price)->associate(Product::class);
        $this->discountService->calculateDiscount();
        return redirect()->back()->with('success', 'Product added to cart successfully');
    }

    public function increment($rowId)
    {
        try {
            $cart = Cart::instance('cart');
            $item = $cart->get($rowId);

            if (!$item) {
                return redirect()->back()->with('error', 'Item not found in cart');
            }

            $cart->update($rowId, $item->qty + 1);

            return redirect()->back()->with('success', 'Item quantity updated');
        } catch (\Exception $e) {
            Log::error('Error incrementing cart item: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to update cart'], 500);
        }
    }

    public function decrement($rowId)
    {
        try {
            $cart = Cart::instance('cart');
            $item = $cart->get($rowId);

            if (!$item) {
                return redirect()->back()->with('error', 'Cart item not found.');
            }

            $cart->update($rowId, $item->qty - 1);

            return redirect()->back()->with('success', 'Cart item quantity decreased.');
        } catch (\Exception $e) {
            Log::error('Error decrementing cart item: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the cart.');
        }
    }

    public function remove($rowId)
    {
        try {
            Cart::instance('cart')->remove($rowId);
            $this->discountService->removeDiscount();
            return redirect()->back()->with('success', 'Item removed from cart');
        } catch (\Exception $e) {
            Log::error('Error removing cart item: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while removing the item from the cart.');
        }
    }

    public function clear()
    {
        try {
            Cart::instance('cart')->destroy();
            $this->discountService->dismissCouponOnCartClear();
            return redirect()->back()->with('success', 'Cart cleared successfully');
        } catch (\Exception $e) {
            Log::error('Error clearing cart: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while clearing the cart.');
        }
    }

    public function applyCouponCode(Request $request)
    {
        $result = $this->couponService->applyCoupon($request->coupon_code);

        if ($result['success']) {
            return redirect()->back()->withSuccess($result['message']);
        } else {
            return redirect()->back()->withError($result['message']);
        }
    }

    public function removeCouponCode()
    {
        try {
            $this->discountService->removeDiscount();
            return redirect()->route('cart.index')->withSuccess('Coupon removed successfully.');
        } catch (\Exception $e) {
            Log::error('Coupon remove was unsuccessful: ' . $e->getMessage());
            return back()->withError('Failed to delete Coupon. Please try again.');
        }
    }
}
