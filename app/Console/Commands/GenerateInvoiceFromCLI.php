<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use Illuminate\Support\Facades\Storage;

class GenerateInvoiceFromCLI extends Command
{
    protected $signature = 'invoice:generate
    {name : Buyer\'s full name}
    {email : Buyer\'s email}
    {phone : Buyer\'s phone number}
    {address : Buyer\'s address}
    {city : Buyer\'s city}
    {postal_code : Buyer\'s postal code}
    {ico : Buyer\'s ICO (optional)}
    {dic : Buyer\'s DIC (optional)}
    {items* : List of items in format name:quantity:price}';

    protected $description = 'Generate an invoice from command line input';

    public function handle()
    {
        // Get input values
        $name = $this->argument('name');
        $email = $this->argument('email');
        $phone = $this->argument('phone');
        $address = $this->argument('address');
        $city = $this->argument('city');
        $postal_code = $this->argument('postal_code');
        $ico = $this->argument('ico') ?? null;
        $dic = $this->argument('dic') ?? null;
        $itemsInput = $this->argument('items');

        // Create buyer instance
        $buyer = new Buyer([
            'name' => $name,
            'custom_fields' => [
                'Email' => $email,
                'Telefónne číslo' => $phone,
                'Adresa' => $address,
                'Mesto' => $city,
                'PSČ' => $postal_code,
                'IČO' => $ico ?? 'N/A',
                'DIČ' => $dic ?? 'N/A',
            ],
        ]);

        // Parse items
        $items = [];
        foreach ($itemsInput as $item) {
            [$itemName, $quantity, $price] = explode(':', $item);
            $items[] = InvoiceItem::make($itemName)
                ->quantity((int)$quantity)
                ->pricePerUnit((float)$price);
        }

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

        $invoice = Invoice::make()
            ->template('aimasf')
            ->seller($seller)
            ->buyer($buyer)
            ->dateFormat('d-m-Y')
            ->currencySymbol('€')
            ->currencyCode('EUR')
            ->notes('Ďakujeme za Váš nákup!')
            ->serialNumberFormat("VF-00035")
            ->addItems($items);

        // Save invoice to storage
        $pdfPath = 'invoices/invoice_' . time() . '.pdf';
        Storage::disk('local')->put($pdfPath, $invoice->stream());

        $this->info("Invoice generated successfully! Saved at: storage/app/{$pdfPath}");
    }
}
