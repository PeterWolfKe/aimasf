<?php

namespace Database\Factories;

use App\Models\DiscountCode;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DiscountCodeFactory extends Factory
{
    protected $model = DiscountCode::class;

    public function definition()
    {
        return [
            'code' => strtoupper(Str::random(10)),
            'stripe_coupon_id' => null,
            'discount_percentage' => $this->faker->numberBetween(5, 50),
            'valid_until' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'active' => true,
        ];
    }
}
