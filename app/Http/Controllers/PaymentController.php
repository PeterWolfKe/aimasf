<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Stripe\Webhook;

class PaymentController extends Controller
{
    public function index()
    {
        return Inertia::render('Payment', [
            'stripePublicKey' => config('stripe.public_key'),
            'sessionData' => session('products', []),
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
            'userDetails.deliveryMethod' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'error' => $validator->errors()->toArray(),
            ], 500);
        }

        Stripe::setApiKey(config('stripe.secret_key'));

        try {
            $data = $request->input('userDetails');
            $products = session('products', []);


            $uniqueOrderId = Str::uuid()->toString();

            $transformedProducts = array_map(function ($product) {
                return [
                    'id' => $product['id'],
                    'quantity' => $product['quantity'],
                ];
            }, $products);

            $order = Order::create([
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
                'verified' => false,
            ]);

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

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => $stripeLineItems,
                'mode' => 'payment',
                'success_url' => url('/api/payment/webhook?session_id={CHECKOUT_SESSION_ID}'),
                'cancel_url' => url('/api/payment/webhook'),
                'metadata' => [
                    'unique_order_id' => $uniqueOrderId,
                ],
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
    public function handleWebhook(Request $request)
    {
        $payload = @file_get_contents('php://input');
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('stripe.webhook_key');
        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);

            if ($event->type === 'payment_intent.succeeded') {
                $intent = $event->data->object;
                $uniqueOrderId = $intent->metadata->unique_order_id;

                $order = Order::where('unique_order_id', $uniqueOrderId)->first();
                if ($order) {
                    $order->update(['verified' => true]);
                }
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
