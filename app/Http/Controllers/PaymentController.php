<?php

namespace App\Http\Controllers;

use App\Mail\OrderSuccessMail;
use App\Models\DiscountCode;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Stripe\Coupon;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Webhook;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $shippingOptions = ShippingOptions::all();
        $sessionProducts = session('products', []);

        $productsWithDetails = array_map(function ($sessionProduct) {
            $product = Product::find($sessionProduct['id']);

            if ($product) {
                $productImages = json_decode($product->product_images, true);
                $image = $productImages[0] ?? null;

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'price' => $product->price,
                    'size' => $sessionProduct['selected_size'],
                    'quantity' => $sessionProduct['quantity'],
                    'image' => $image
                ];
            }

            return null;
        }, $sessionProducts);
        $productsWithDetails = array_filter($productsWithDetails);

        return Inertia::render('Payment', [
            'stripePublicKey' => config('stripe.public_key'),
            'productsData' => $productsWithDetails,
            'shippingOptions' => $shippingOptions,
        ])
        ->toResponse($request)
        ->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string',
            'selected_size' => 'string',
            'quantity' => 'required|integer|min:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->toArray(),
            ], 422);
        }

        $products = session('products', []);

        $existingProductIndex = null;
        foreach ($products as $index => $product) {
            if ($product['id'] === $request->input('id') && $product['selected_size'] === $request->input('selected_size')) {
                $existingProductIndex = $index;
                break;
            }
        }

        if ($existingProductIndex !== null) {
            $products[$existingProductIndex]['quantity'] += $request->input('quantity');
        } else {
            $products[] = [
                'id' => $request->input('id'),
                'selected_size' => $request->input('selected_size'),
                'quantity' => $request->input('quantity'),
            ];
        }

        session(['products' => $products]);

        return response()->json(['message' => 'Item added to session']);
    }

    public function processPayment(Request $request)
    {
        // Existing validation
        $validator = Validator::make($request->all(), [
            'amount' => 'required|integer|min:1',
            'userDetails' => 'required|array',
            'userDetails.email' => 'required|email',
            'userDetails.firstName' => 'required|string',
            'userDetails.lastName' => 'required|string',
            'userDetails.address' => 'required|string',
            'userDetails.apartment' => 'nullable|string',
            'userDetails.postalCode' => 'required|string',
            'userDetails.city' => 'required|string',
            'userDetails.phone' => 'nullable|string',
            'userDetails.deliveryMethod' => 'required|string|exists:shipping_options,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->toArray(),
            ], 500);
        }

        Stripe::setApiKey(config('stripe.secret_key'));

        try {
            $shippingOption = ShippingOptions::where('id', $request->input('userDetails.deliveryMethod'))->first();
            $products = session('products', []);

            $uniqueOrderId = collect(str_split(Str::random(16, '1234567890'), 4))->join('-');

            $stripeLineItems = [];
            $totalPrice = 0;

            foreach ($products as $product) {
                $dbProduct = Product::where('id', $product['id'])->first();
                if ($dbProduct) {
                    $lineItemPrice = $dbProduct->price * $product['quantity'];
                    $stripeLineItems[] = [
                        'price_data' => [
                            'currency' => 'eur',
                            'product_data' => [
                                'name' => $dbProduct->name . ' (' . $product['selected_size'] . ')',
                            ],
                            'unit_amount' => $dbProduct->price * 100,
                        ],
                        'quantity' => $product['quantity'],
                    ];
                    $totalPrice += $lineItemPrice;
                }
            }

            // Add shipping
            $totalPrice += $shippingOption->price;
            $stripeLineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Shipping: ' . $shippingOption->title,
                    ],
                    'unit_amount' => $shippingOption->price * 100,
                ],
                'quantity' => 1,
            ];

            // Apply discount if available
            $discount_code = session('discount', null);
            $discount = DiscountCode::where('code', $discount_code)->first();

            if ($discount && $discount->active && (!$discount->valid_until || $discount->valid_until >= now())) {
                $stripeCouponId = $discount->stripe_coupon_id;

                $session = Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => $stripeLineItems,
                    'mode' => 'payment',
                    'metadata' => [
                        'unique_order_id' => $uniqueOrderId,
                    ],
                    'discounts' => [
                        [
                            'coupon' => $stripeCouponId,
                        ],
                    ],
                    'success_url' => url('/payment-success?session_id={CHECKOUT_SESSION_ID}'),
                    'cancel_url' => url('/payment-cancel'),
                ]);
            } else {
                Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => $stripeLineItems,
                    'mode' => 'payment',
                    'metadata' => [
                        'unique_order_id' => $uniqueOrderId,
                    ],
                    'success_url' => url('/payment-success?session_id={CHECKOUT_SESSION_ID}'),
                    'cancel_url' => url('/payment-cancel'),
                ]);
            }

            Order::create([
                'unique_order_id' => $uniqueOrderId,
                'email' => $request->input('userDetails.email'),
                'first_name' => $request->input('userDetails.firstName'),
                'last_name' => $request->input('userDetails.lastName'),
                'address' => $request->input('userDetails.address'),
                'apartment_suite' => $request->input('userDetails.apartment'),
                'postal_code' => $request->input('userDetails.postalCode'),
                'city' => $request->input('userDetails.city'),
                'phone' => $request->input('userDetails.phone'),
                'delivery_method' => $request->input('userDetails.deliveryMethod'),
                'products' => json_encode(array_map(function ($product) {
                    return [
                        'id' => $product['id'],
                        'quantity' => $product['quantity'],
                    ];
                }, $products)),
                'paid' => false,
                'discount_code' => $discount ? $discount['code'] : null,
            ]);

            return response()->json([
                'success' => true,
                'checkoutUrl' => $session->url,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function paymentSuccess(Request $request)
    {
        Stripe::setApiKey(config('stripe.secret_key'));

        $sessionId = $request->query('session_id');

        $session = Session::retrieve($sessionId);

        $uniqueOrderId = $session->metadata->unique_order_id;

        $amount = $session->amount_total / 100;

        $order = Order::where('unique_order_id', $uniqueOrderId)->first();
        if ($order) {
            $order->update(['paid' => true]);
            if (!$order->mail_sended) {
                $order->mail_sended = true;
                $order->save();

                $products = array_map(function ($item) {
                    $product = Product::find($item['id']);
                    return [
                        'name' => $product->name,
                        'quantity' => $item['quantity'],
                        'size' => $product->size,
                        'price' => $product->price
                    ];
                }, json_decode($order->products, true));

                $totalPrice = array_reduce($products, function ($carry, $product) {
                    return $carry + ($product['price'] * $product['quantity']);
                }, 0);

                $details = [
                    'first_name' => $order->first_name,
                    'last_name' => $order->last_name,
                    'delivery_method' => $order->shippingOption->title,
                    'unique_order_id' => $order->unique_order_id,
                    'products' => $products,
                    'total_price' => $totalPrice,
                ];

                Mail::to($order->email)->send(new OrderSuccessMail($details));
            }
        }

        session()->forget('products');
        return Inertia::render('PaymentSuccess', [
            'order' => $order,
            'amount' => $amount
        ]);
    }

    public function applyDiscount(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->toArray(),
            ], 422);
        }

        $discountCode = $request->input('code');
        $discount = DiscountCode::where('code', $discountCode)
            ->where('active', true)
            ->where(function ($query) {
                $query->whereNull('valid_until')->orWhere('valid_until', '>=', now());
            })
            ->first();

        if (!$discount) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired discount code.',
            ], 404);
        }

        session(['discount' => [
            'code' => $discount->code,
            'percentage' => $discount->discount_percentage,
        ]]);

        return response()->json([
            'success' => true,
            'message' => 'Discount code applied successfully.',
            'discount' => [
                'code' => $discount->code,
                'percentage' => $discount->discount_percentage,
            ],
        ]);
    }
    public function createDiscountCode($code, $discount_percentage)
    {
        Stripe::setApiKey(config('stripe.secret_key'));

        try {
            $coupon = Coupon::create([
                'percent_off' => $discount_percentage,
                'duration' => 'once',
            ]);

            $discountCode = DiscountCode::create([
                'code' => $code,
                'discount_percentage' => $discount_percentage,
                'valid_until' => null,
                'active' => true,
            ]);

            $discountCode->update(['stripe_coupon_id' => $coupon->id]);

            return $discountCode;
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
