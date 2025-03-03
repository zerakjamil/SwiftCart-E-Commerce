<?php

namespace Database\Factories\Admin\V1;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Admin\V1\Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'locality' => $this->faker->streetName,
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'country' => $this->faker->country,
            'landmark' => $this->faker->optional()->secondaryAddress,
            'zip' => $this->faker->postcode,
            'type' => $this->faker->randomElement(['home', 'work', 'other']),
            'is_default' => $this->faker->boolean(20), // 20% chance of being default
        ];
    }

    /**
     * Indicate that the address is the default one.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function default()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_default' => true,
            ];
        });
    }

    /**
     * Indicate that the address is of type 'home'.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function home()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'home',
            ];
        });
    }

    /**
     * Indicate that the address is of type 'work'.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function work()
    {
        return $this->state(function (array $attributes) {
            return [
                'type' => 'work',
            ];
        });
    }
}
