<?php

namespace App\Http\Controllers;

use App\Models\Admin\V1\Product;
use Illuminate\Http\Request;
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
}
