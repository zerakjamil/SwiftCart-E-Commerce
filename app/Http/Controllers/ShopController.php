<?php

namespace App\Http\Controllers;

use App\Models\Admin\V1\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $size = $request->query('size') ?? 12;
        $products = Product::latest()->paginate($size);
        return view('guest.shop.index',compact('products','size'));
    }

    public function show(Product $product): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $related_products = Product::where('slug', '<>',$product->slug)->inRandomOrder()->limit(8)->get();
        return view('guest.shop.show',compact('product','related_products'));
    }
}
