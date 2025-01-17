<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShippingOptionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvFile = database_path('../storage/shipping_options.csv');
        $fileHandle = fopen($csvFile, 'r');

        fgetcsv($fileHandle, 1000, ',');

        while (($row = fgetcsv($fileHandle, 1000, ',')) !== false) {
            try {
                DB::table('shipping_options')->insert([
                    'id' => $row[0],
                    'title' => $row[1],
                    'price' => $row[2],
                    'address' => $row[3],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } catch (\Throwable $e) {
                echo "Error inserting shipping option: " . $e->getMessage();
            }
        }
        fclose($fileHandle);
    }
}
