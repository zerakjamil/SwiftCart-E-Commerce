<?php

namespace App\Http\Controllers;

use App\Models\Admin\V1\Product;
use Illuminate\Http\Request;
use Surfsidemedia\Shoppingcart\Facades\Cart;

class WishlistController extends Controller
{

    public function index()
    {
        return view('guest.wishlist.index');
    }

    public function add(Request $request)
    {
        Cart::instance('wishlist')->add($request->id, $request->name, $request->quantity, $request->price)
            ->associate(Product::class);

        return redirect()->back()->with('success', 'Item added to wishlist');
    }
}
