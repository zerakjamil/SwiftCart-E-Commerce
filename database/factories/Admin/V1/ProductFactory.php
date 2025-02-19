<?php

namespace Database\Factories\Admin\V1;

use App\Models\Admin\V1\Brand;
use App\Models\Admin\V1\Category;
use App\Models\Admin\V1\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'slug' => $this->faker->unique()->slug,
            'description' => $this->faker->paragraph,
            'short_description' => $this->faker->sentence,
            'regular_price' => $this->faker->randomFloat(2, 10, 1000),
            'sale_price' => $this->faker->randomFloat(2, 10, 1000),
            'image' => $this->faker->imageUrl(),
            'images' => json_encode([
                'full' => $this->faker->imageUrl(),
                'thumbnail' => $this->faker->imageUrl()
            ]),
            'SKU' => $this->faker->unique()->uuid,
            'featured' => $this->faker->boolean,
            'quantity' => $this->faker->numberBetween(1, 100),
            'stock_status' => $this->faker->randomElement(['instock', 'outofstock']),
            'brand_id' => Brand::factory(),
            'category_id' => Category::factory(),
        ];
    }
}
