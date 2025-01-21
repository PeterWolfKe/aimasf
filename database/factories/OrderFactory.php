<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class OrderFactory extends Factory
{
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'address' => $this->faker->streetAddress(),
            'apartment_suite' => $this->faker->optional()->secondaryAddress(),
            'postal_code' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'delivery_method' => $this->faker->randomElement(['standard', 'express']),
            'products' => json_encode([
                ['id' => Product::inRandomOrder()->first()->id, 'quantity' => $this->faker->numberBetween(1, 5)],
            ]),
            'unique_order_id' => Str::uuid(),
            'paid' => $this->faker->boolean(),
        ];
    }
}
