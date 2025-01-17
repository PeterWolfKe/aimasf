<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Order;
use App\Models\ShippingOptions;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ProductsSeeder::class);
        $this->call(ShippingOptionsSeeder::class);
        $this->call(UserSeeder::class);
        if (config('app.debug')) {
            $this->call(OrderSeeder::class);
        }
    }
}
