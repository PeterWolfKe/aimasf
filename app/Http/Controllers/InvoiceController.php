<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use ConsoleTVs\Invoices\Classes\Invoice;

class InvoiceController extends Controller
{
    public function generateInvoice($orderId)
    {
        $order = Order::where('unique_order_id', $orderId)->firstOrFail();

        $productDetails = json_decode($order->products, true);

        $invoice = Invoice::make()
            ->number($order->unique_order_id)
            ->due_date(Carbon::parse($order->created_at)->addDays(30))
            ->customer([
                'name'      => 'Èrik Campobadal Forés',
                'id'        => '12345678A',
                'phone'     => '+34 123 456 789',
                'location'  => 'C / Unknown Street 1st',
                'zip'       => '08241',
                'city'      => 'Manresa',
                'country'   => 'Spain',
            ])
            ->notes('Thank you for your purchase!');

        foreach ($productDetails as $productDetail) {
            $product = Product::find($productDetail['id']);

            if ($product) {
                $productImages = json_decode($product->product_images, true);
                $image = $productImages[0] ?? null;

                $invoice->addItem(
                    $product->name,
                    $product->price,
                    $productDetail['quantity'],
                    $productDetail['quantity'] * $product->price,
                );
            }
        }
        $invoice->business([
            'name' => 'Aimasf',
            'address' => 'Poštová 9',
            'city' => 'Košice',
            'postal_code' => '042 42',
            'phone' => '+421 919 195 062',
            'email' => 'aima@aimasf.sk',
            'website' => 'https://www.aimasf.sk',
        ]);

        return $invoice->download('invoice_' . $order->unique_order_id . '.pdf');
    }
}
