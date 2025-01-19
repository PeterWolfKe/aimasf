<?php

namespace App\Http\Controllers;

use App\Models\DiscountCode;
use App\Models\InvoiceCounter;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingOptions;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
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
            'name' => 'Aimasf',
            'address' => 'Poštová 9',
            'phone' => '+421 919 195 062',
            'custom_fields' => [
                'Mesto' => 'Košice',
                'PSČ' => '042 42',
                'email' => 'aima@aimasf.sk',
            ]
        ]);

        $productDetails = json_decode($order->products, true);
        $items = [];
        $totalAmount = 0;

        foreach ($productDetails as $productDetail) {
            $product = Product::find($productDetail['id']);
            if ($product) {
                $itemPrice = $product->price * $productDetail['quantity'];
                $items[] = (new InvoiceItem())
                    ->title($product->name)
                    ->pricePerUnit($product->price)
                    ->quantity($productDetail['quantity']);
                $totalAmount += $itemPrice;
            }
        }

        $shippingOption = ShippingOptions::find($order->delivery_method);
        $shippingPrice = $shippingOption ? $shippingOption->price : 0;
        $totalAmount += $shippingPrice;


        $discount = DiscountCode::where('code', $order->discount_code)
            ->where('active', true)
            ->where(function ($query) {
                $query->whereNull('valid_until')
                    ->orWhere('valid_until', '>=', now());
            })
            ->first();
        if ($discount) {
            $discountPrice = $totalAmount * ($discount->discount_percentage / 100);
            $items[] = (new InvoiceItem())
                ->title('Zľava (' . round($discount->discount_percentage, 0) . '%)')
                ->pricePerUnit('-' . number_format($discountPrice, 2))
                ->quantity(1);
            $totalAmount -= $discountPrice;
        }

        $currentYear = Carbon::now()->year;
        $invoiceCounter = InvoiceCounter::firstOrCreate(
            ['year' => $currentYear],
            ['counter' => 0]
        );

        $invoiceCounter->increment('counter');

        $invoiceNumber = 'VF-' . $currentYear . '-' . str_pad($invoiceCounter->counter, 5, '0', STR_PAD_LEFT);

        $invoice = Invoice::make()
            ->template('aimasf')
            ->seller($seller)
            ->buyer($buyer)
            ->date($order->created_at)
            ->shipping($shippingPrice)
            ->dateFormat('d-m-Y')
            ->currencySymbol('€')
            ->currencyCode('EUR')
            ->notes('Ďakujeme za Váš nákup!')
            ->serialNumberFormat($invoiceNumber)
            ->addItems($items);

        $pdfRendered = $invoice->render()->output;

        $fileName = 'invoice_' . $invoiceNumber . '.pdf';

        Storage::put('invoices/' . $fileName, $pdfRendered);

        return $pdfRendered;
    }
}
