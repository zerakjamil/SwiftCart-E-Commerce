<?php

namespace Database\Seeders\Admin\V1;

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Fashion',
            'Home & Garden',
            'Sporting Goods',
            'Toys & Hobbies',
            'Health & Beauty',
            'Motors',
            'Collectibles & Art',
            'Business & Industrial',
            'Music',
            'Books',
            'Movies & TV Shows',
            'Pet Supplies',
            'Crafts',
            'Travel',
            'Tickets',
            'Gift Cards & Coupons',
            'Real Estate',
            'Services',
            'Other',
        ];

        foreach ($categories as $category) {
            \App\Models\Admin\V1\Category::factory()->create(['name' => $category]);
        }
    }
}
