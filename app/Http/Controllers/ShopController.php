<?php

namespace App\Http\Controllers;

use App\Models\Admin\V1\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $products = Product::latest()->paginate(12);
        return view('guest.shop.index',compact('products'));
    }

    public function show(Product $product): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $related_products = Product::where('slug', '<>',$product->slug)->inRandomOrder()->limit(8)->get();
        return view('guest.shop.show',compact('product','related_products'));
    }
}
