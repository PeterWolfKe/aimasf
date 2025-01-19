<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function generateInvoice($orderId)
    {
        $order = Order::where('unique_order_id', $orderId)->firstOrFail();

        $productDetails = json_decode($order->products, true);

        $productsWithDetails = array_map(function ($productDetail) {
            $product = Product::find($productDetail['id']);

            if ($product) {
                $productImages = json_decode($product->product_images, true);
                $image = $productImages[0] ?? null;

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'size' => $productDetail['size'] ?? 'N/A',
                    'quantity' => $productDetail['quantity'],
                    'image' => $image
                ];
            }

            return null;
        }, $productDetails);

        $totalAmount = 0;
        foreach ($productsWithDetails as $product) {
            $totalAmount += $product['quantity'] * $product['price'];
        }

        $pdf = PDF::loadView('invoice', [
            'company_name' => 'Aimasf',
            'company_address' => 'Poštová 9',
            'company_city_postcode' => 'Košice, 042 42',
            'company_phone' => '+421 919 195 062',
            'company_email' => 'aima@aimasf.sk',
            'invoice_number' => $order->unique_order_id,
            'invoice_date' => $order->created_at->format('d-m-Y'),
            'customer_name' => $order->first_name . ' ' . $order->last_name,
            'customer_email' => $order->email,
            'customer_address' => $order->address . ($order->apartment_suite ? ', ' . $order->apartment_suite : ''),
            'customer_postal_code' => $order->postal_code,
            'customer_city' => $order->city,
            'customer_phone' => $order->phone,
            'delivery_method' => $order->delivery_method,
            'products' => $productsWithDetails,
            'discount_code' => $order->discount_code,
            'total_amount' => $totalAmount
        ]);

        $pdf->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);

        return $pdf->download('invoice.pdf');
    }
}
