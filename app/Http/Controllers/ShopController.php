<?php

namespace App\Http\Controllers;

use App\Models\Admin\V1\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(12);
        return view('guest.shop.index',compact('products'));
    }
}
