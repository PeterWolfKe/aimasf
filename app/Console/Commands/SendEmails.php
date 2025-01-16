<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use App\Mail\OrderSuccessMail;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    protected $signature = 'email:send';
    protected $description = 'Send automated emails';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {

        $order = [
            'first_name' => 'Ján',
            'last_name' => 'Novák',
            'delivery_method' => 'express',
            'unique_order_id' => 'abcd-1234-efgh-5678',
            'products' => [
                ['product_id' => '00000001', 'quantity' => 2],
                ['product_id' => '00000001', 'quantity' => 1],
            ],
        ];

        $products = array_map(function ($item) {
            $product = Product::find($item['product_id']);
            return [
                'name' => $product->name,
                'quantity' => $item['quantity'],
                'size' => $product->size,
                'price' => $product->price
            ];
        }, $order['products']); // Corrected to access $order as an array

        // Calculate the total price of all products
        $totalPrice = array_reduce($products, function ($carry, $product) {
            return $carry + ($product['price'] * $product['quantity']);
        }, 0);

        $details = [
            'first_name' => $order['first_name'],
            'last_name' => $order['last_name'],
            'delivery_method' => $order['delivery_method'],
            'unique_order_id' => $order['unique_order_id'],
            'products' => $products,
            'total_price' => $totalPrice,
        ];

        // Send the email to the specified address
        Mail::to('info@12volt.sk')->send(new OrderSuccessMail($details));

        $this->info('Email sent successfully!');
    }
}
