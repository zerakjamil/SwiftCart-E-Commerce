<?php

namespace App\Http\Controllers;

use App\Constants\ProductSortOptions;
use App\Models\Admin\V1\Brand;
use App\Models\Admin\V1\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $size = $request->query('size', 12);
        $order = $request->query('order', 'latest');
        $fbrand = $request->query('brands');

        [$column, $direction] = ProductSortOptions::ORDER_OPTIONS[$order] ?? ['id', 'DESC'];

        $brands = Brand::orderBy('name','ASC')->get();
        $products = Product::where(function($query) use ($fbrand){
            $query->whereIn('brand_id',explode(',',$fbrand))->orWhereRaw("'".$fbrand."' = ''");
        })->orderBy($column, $direction)->paginate($size);

        return view('guest.shop.index', compact(
            'products',
            'size',
            'order',
            'brands',
            'fbrand'
        ));
    }

    public function show(Product $product): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\Foundation\Application
    {
        $related_products = Product::where('slug', '<>',$product->slug)->inRandomOrder()->limit(8)->get();
        return view('guest.shop.show',compact('product','related_products'));
    }
}
