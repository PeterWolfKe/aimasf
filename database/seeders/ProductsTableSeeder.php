<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $csvFile = database_path('../storage/products.csv');
        $fileHandle = fopen($csvFile, 'r');

        $header = fgetcsv($fileHandle, 1000, ',');

        while (($row = fgetcsv($fileHandle, 1000, ',')) !== false) {
            $productData = array_combine($header, $row);

            try {
                DB::table('products')->insert([
                    'id' => $productData['id'],
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'size' => $productData['size'],
                    'created_at' => $productData['created_at'] ?? now(),
                    'updated_at' => $productData['updated_at'] ?? now(),
                ]);
            } catch (\Throwable $e) {
                echo "Error inserting product: " . $e->getMessage();
                dd($row);
            }
        }
        fclose($fileHandle);
    }
}
