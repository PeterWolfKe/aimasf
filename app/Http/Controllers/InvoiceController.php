<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;

class InvoiceController extends Controller
{
    public function generateInvoice($orderId)
    {

        App::setLocale('sk');
        $order = Order::where('unique_order_id', $orderId)->firstOrFail();

        $buyer = new Buyer([
            'name' => $order->first_name . ' ' . $order->last_name,
            'custom_fields' => [
                'Email' => $order->email,
                'Telefónne číslo' => $order->phone,
                'Adresa' => $order->address . ($order->apartment_suite ? ', ' . $order->apartment_suite : ''),
                'Mesto' => $order->city,
                'PSČ' => $order->postal_code,
            ],
        ]);
        $seller = new Party([
            'name' => 'Amazon',
            'address' => 'Poštová 9',
            'city' => 'Košice',
            'postal_code' => '042 42',
            'phone' => '+421 919 195 062',
            'email' => 'aima@aimasf.sk',
            'website' => 'https://www.aimasf.sk',
        ]);

        $productDetails = json_decode($order->products, true);
        $items = [];

        foreach ($productDetails as $productDetail) {
            $product = Product::find($productDetail['id']);
            if ($product) {
                $items[] = (new InvoiceItem())
                    ->title($product->name)
                    ->pricePerUnit($product->price)
                    ->quantity($productDetail['quantity']);
            }
        }

        $invoice = Invoice::make()
            ->seller($seller)
            ->buyer($buyer)
            ->date($order->created_at)
            ->dateFormat('d-m-Y')
            ->currencySymbol('€')
            ->currencyCode('EUR')
            ->notes('Ďakujeme za Váš nákup!')
            ->addItems($items);

        dd($order->getFullPrice());

        return $invoice->download('invoice_' . $order->unique_order_id . '.pdf');
    }
}
