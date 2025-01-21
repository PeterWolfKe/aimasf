<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Product;
use App\Mail\OrderDelivered;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send testing mail';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $order = Order::inRandomOrder()->first();

        $products = array_map(function ($item) {
            $product = Product::find($item['id']);
            return [
                'name' => $product->name,
                'quantity' => $item['quantity'],
                'size' => $product->size,
                'price' => $product->price
            ];
        }, json_decode($order['products'], true));

        $totalPrice = array_reduce($products, function ($carry, $product) {
            return $carry + ($product['price'] * $product['quantity']);
        }, 0);

        $details = [
            'first_name' => $order->first_name,
            'last_name' => $order->last_name,
            'delivery_method' => $order->shippingOption->title,
            'unique_order_id' => $order->unique_order_id,
            'products' => $products,
        ];

        Mail::to('julkoklein@gmail.com')->send(new OrderDelivered($details));

        $this->info('Email sent successfully!');
    }
}
