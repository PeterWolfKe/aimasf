<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\InvoiceCounter;
use App\Models\Order;
use App\Models\DiscountCode;
use App\Models\Product;
use App\Models\ShippingOption;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Carbon\Carbon;

class GenerateInvoices extends Command
{
    protected $signature = 'invoices:generate';
    protected $description = 'Generate invoices for all orders starting with invoice counter 1';

    public function handle()
    {
        App::setLocale('sk');

        $currentYear = Carbon::now()->year;
        $invoiceCounter = InvoiceCounter::updateOrCreate(
            ['year' => $currentYear],
            ['counter' => 0]
        );

        $orders = Order::where('status', '!=', 0)->get();

        foreach ($orders as $order) {
            $invoiceCounter->increment('counter');

            $invoiceNumber = 'VF-' . $currentYear . '-' . str_pad($invoiceCounter->counter, 5, '0', STR_PAD_LEFT);

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
                        ->pricePerUnit($productDetail['price'])
                        ->quantity($productDetail['quantity']);
                    $totalAmount += $itemPrice;
                }
            }

            $shippingOption = ShippingOption::find($order->shipping_option_id);
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
                ->date(Carbon::parse($order->created_at))
                ->addItems($items);

            $pdfRendered = $invoice->render()->output;
            $fileName = 'invoice_' . $invoiceNumber . '.pdf';
            Storage::put('invoices/' . $fileName, $pdfRendered);

            $this->info("Invoice generated: $fileName");
        }

        $this->info('All invoices have been generated successfully.');
    }
}
