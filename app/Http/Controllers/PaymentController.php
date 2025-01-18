<?php

namespace App\Http\Controllers;

use App\Mail\OrderSuccessMail;
use App\Models\Order;
use App\Models\Product;
use App\Models\ShippingOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;
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

            $data = $request->input('userDetails');
            $products = session('products', []);


            $uniqueOrderId = collect(str_split(Str::random(16, '1234567890'), 4))->join('-');

            $transformedProducts = array_map(function ($product) {
                return [
                    'id' => $product['id'],
                    'quantity' => $product['quantity'],
                ];
            }, $products);

            $stripeLineItems = [];
            foreach ($products as $index => $product) {
                $dbProduct = Product::where('id', $product['id'])->first();
                if ($dbProduct) {
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
                } else {
                    Log::warning('Product not found in database for ID:', ['id' => $product['id']]);
                }
            }
            $stripeLineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Doprava: ' . $shippingOption->title,
                    ],
                    'unit_amount' => $shippingOption->price * 100,
                ],
                'quantity' => 1,
            ];

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $stripeLineItems,
                'mode' => 'payment',
                'metadata' => [
                    'unique_order_id' => $uniqueOrderId,
                ],
                'success_url' => url('/payment-success?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => url('/payment-cancel'),
            ]);

            Order::create([
                'unique_order_id' => $uniqueOrderId,
                'email' => $data['email'],
                'first_name' => $data['firstName'],
                'last_name' => $data['lastName'],
                'address' => $data['address'],
                'apartment_suite' => $data['apartment'],
                'postal_code' => $data['postalCode'],
                'city' => $data['city'],
                'phone' => $data['phone'],
                'delivery_method' => $data['deliveryMethod'],
                'products' => json_encode($transformedProducts),
                'paid' => false,
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
}
