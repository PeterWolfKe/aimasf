<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DiscountCode;

class DiscountCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DiscountCode::factory()->count(2)->create();
    }
}
