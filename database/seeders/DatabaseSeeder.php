<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Order;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ProductsTableSeeder::class);
        $this->call(UserSeeder::class);
        if (config('app.debug')) {
            $this->call(OrderSeeder::class);
        }
    }
}
