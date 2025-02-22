<?php

namespace App\Http\Controllers;

use App\Models\Admin\V1\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::instance('cart')->content();
        $suggested_products = Product::inRandomOrder()->limit(4)->get();
        return view('guest.cart.index', compact('items','suggested_products'));
    }

    public function add(Request $request)
    {
        Cart::instance('cart')->add($request->id, $request->name, $request->quantity, $request->price)->associate(Product::class);
        return redirect()->back()->with('success', 'Product added to cart successfully');
    }

public function increment($rowId)
{
    try {
        $cart = Cart::instance('cart');
        $item = $cart->get($rowId);

        if (!$item) {
            return redirect()->back()->with('error' , 'Item not found in cart');
        }

        $cart->update($rowId, $item->qty + 1);

        return redirect()->back()->with('success',  'Item quantity updated');
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
        return redirect()->back()->with('success', 'Cart cleared successfully');
    } catch (\Exception $e) {
        Log::error('Error clearing cart: ' . $e->getMessage());
        return redirect()->back()->with('error', 'An error occurred while clearing the cart.');
    }
}

}
