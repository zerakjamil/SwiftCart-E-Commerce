<?php

namespace App\Http\Controllers;

use App\Constants\ProductSortOptions;
use App\Models\Admin\V1\Brand;
use App\Models\Admin\V1\Category;
use App\Models\Admin\V1\Product;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class ShopController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $this->getFilters($request);
        $sortingOptions = $this->getSortingOptions($filters['order']);

        $brands = $this->getBrands();
        $categories = $this->getCategories();
        $products = $this->getFilteredProducts($filters, $sortingOptions);

        return view('guest.shop.index', compact(
            'products',
            'brands',
            'categories',
            'filters'
        ));
    }

    private function getFilters(Request $request): array
    {
        return [
            'size' => $request->query('size', 12),
            'order' => $request->query('order', 'latest'),
            'brands' => $request->query('brands'),
            'categories' => $request->query('categories'),
            'price' => $request->query('price'),
        ];
    }

    private function getSortingOptions(string $order): array
    {
        return ProductSortOptions::ORDER_OPTIONS[$order] ?? ['created_at', 'DESC'];
    }

    private function getBrands()
    {
        return Brand::withCount('products')->orderBy('name', 'ASC')->get();
    }

    private function getCategories()
    {
        return Category::withCount('products')->orderBy('name', 'ASC')->get();
    }

    private function getFilteredProducts(array $filters, array $sortingOptions)
    {
        [$column, $direction] = $sortingOptions;

        return Product::when($filters['brands'], function ($query) use ($filters) {
            $query->whereIn('brand_id', explode(',', $filters['brands']));
        })
        ->when($filters['categories'], function ($query) use ($filters) {
            $query->whereIn('category_id', explode(',', $filters['categories']));
        })
        ->orderBy($column, $direction)
        ->paginate($filters['size']);
    }

    public function show(Product $product): View
    {
        $related_products = Product::where('slug', '<>', $product->slug)->inRandomOrder()->limit(8)->get();
        return view('guest.shop.show', compact('product', 'related_products'));
    }
}
