<?php

namespace App\Http\Controllers;

use App\Http\Services\DiscountService;
use App\Models\Admin\V1\Product;
use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class WishlistController extends Controller
{
    private DiscountService $discountService;

    public function __construct(DiscountService $discountService)
    {
        $this->discountService = $discountService;
    }


    public function index(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $items = Cart::instance('wishlist')->content();
        return view('guest.wishlist.index',compact('items'));
    }

    public function add(Request $request): \Illuminate\Http\RedirectResponse
    {
        Cart::instance('wishlist')->add($request->id, $request->name, $request->quantity, $request->price)
            ->associate(Product::class);

        return redirect()->back()->with('success', 'Item added to wishlist');
    }

    public function removeItemFromWishlist($rowId): \Illuminate\Http\RedirectResponse
    {
        Cart::instance('wishlist')->remove($rowId);
        return redirect()->back()->with('success', 'Item removed from wishlist');
    }

    public function clearWishlist(): \Illuminate\Http\RedirectResponse
    {
        Cart::instance('wishlist')->destroy();
        return redirect()->back()->with('success', 'Wishlist cleared');
    }

    public function moveToCart($rowId)
    {
        $item = Cart::instance('wishlist')->get($rowId);
        Cart::instance('wishlist')->remove($rowId);
        Cart::instance('cart')->add($item->id, $item->name, $item->qty, $item->price)
            ->associate(Product::class);
        $this->discountService->updateCartTotals();
        return redirect()->back()->with('success', 'Item moved to cart');
    }
}
