<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use App\Models\Product;

class UpdateOrderProductsPrice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:update-products-price';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update products in orders by adding price to each product in the JSON';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Fetch all orders
        $orders = Order::all();

        foreach ($orders as $order) {
            // Decode the products JSON
            $products = json_decode($order->products, true);

            if (is_array($products)) {
                foreach ($products as &$product) {
                    // Fetch the price from the Product model using the product ID
                    $productData = Product::where('id', $product['id'])->first();

                    if ($productData) {
                        $product['price'] = $productData->price;
                    } else {
                        $this->warn("Product ID {$product['id']} not found for Order ID {$order->id}");
                    }
                }

                // Update the products JSON in the order
                $order->products = json_encode($products);
                $order->save();
                $this->info("Updated Order ID {$order->id}");
            } else {
                $this->warn("Invalid products JSON in Order ID {$order->id}");
            }
        }

        $this->info('All orders updated successfully.');
        return Command::SUCCESS;
    }
}
