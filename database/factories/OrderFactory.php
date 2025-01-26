<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ShippingOption;
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
            'shipping_option_id' => ShippingOption::inRandomOrder()->first()->id,
            'products' => json_encode([
                ['id' => Product::inRandomOrder()->first()->id, 'quantity' => $this->faker->numberBetween(1, 5)],
            ]),
            'unique_order_id' => Str::uuid(),
            'status' => $this->faker->numberBetween(0, 3),
            'ip_address' => $this->faker->ipv4(),
        ];
    }
}
