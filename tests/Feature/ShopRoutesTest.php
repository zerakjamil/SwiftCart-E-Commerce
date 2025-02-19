<?php

namespace Tests\Feature;

use App\Models\Admin\V1\Brand;
use App\Models\Admin\V1\Category;
use App\Models\Admin\V1\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShopRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_shop_index_route()
    {
        $response = $this->get(route('shop.index'));

        $response->assertStatus(200);
        $response->assertViewIs('guest.shop.index');
    }

    public function test_shop_show_route()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('shop.show', $product));

        $response->assertStatus(200);
        $response->assertViewIs('guest.shop.show');
        $response->assertViewHas('product', $product);
    }

    public function test_shop_category_route()
    {
        $category = Category::factory()->create();

        $response = $this->get(route('shop.category', $category));

        $response->assertStatus(200);
        $response->assertViewIs('guest.shop.category');
        $response->assertViewHas('category', $category);
    }

    public function test_shop_brand_route()
    {
        $brand = Brand::factory()->create();

        $response = $this->get(route('shop.brand', $brand));

        $response->assertStatus(200);
        $response->assertViewIs('guest.shop.brand');
        $response->assertViewHas('brand', $brand);
    }
}
