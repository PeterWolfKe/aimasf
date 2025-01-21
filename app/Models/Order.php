<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'first_name',
        'last_name',
        'address',
        'apartment_suite',
        'postal_code',
        'city',
        'phone',
        'shipping_option_id',
        'products',
        'unique_order_id',
        'paid',
        'discount_code'
    ];

    public function shippingOption(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ShippingOption::class, 'shipping_option_id', 'id');
    }
    public function getFullPrice(): float
    {
        $products = json_decode($this->products, true);

        $totalPrice = 0;

        $productsWithDetails = array_map(function ($sessionProduct) use (&$totalPrice) {
            $product = Product::find($sessionProduct['id']);

            if ($product) {
                $productImages = json_decode($product->product_images, true);
                $image = $productImages[0] ?? null;

                $totalPriceForProduct = $product->price * $sessionProduct['quantity'];
                $totalPrice += $totalPriceForProduct;

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'quantity' => $sessionProduct['quantity'],
                    'image' => $image
                ];
            }

            return null;
        }, $products);

        $deliveryOption = $this->shippingOption;
        if ($deliveryOption) {
            $totalPrice += $deliveryOption->price;
        }

        if ($this->discount_code) {
            $discount = DiscountCode::where('code', $this->discount_code)->first();

            if ($discount && $discount->active) {
                $totalPrice -= ($totalPrice * ($discount->discount_percentage / 100));
            }
        }

        return round($totalPrice, 2);
    }
}
