<?php

namespace Database\Seeders;

use App\Models\Admin\V1\Address;
use App\Models\User;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function ($user) {
            $addressCount = rand(1, 3);

            Address::factory()->count($addressCount)->create([
                'user_id' => $user->id
            ]);

            $user->addresses()->first()->update(['is_default' => true]);
        });

        Address::factory()->count(20)->create();

        Address::factory()->count(5)->home()->create();
        Address::factory()->count(5)->work()->create();
        Address::factory()->count(5)->default()->create();
    }
}
