<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function index()
    {
        return Inertia::render('Payment', [
            'stripePublicKey' => config('stripe.public_key'),
        ]);
    }

    public function processPayment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|integer|min:1',
            'paymentMethodId' => 'required|string',
            'userDetails' => 'required|array',
            'userDetails.email' => 'required|email',
            'userDetails.firstName' => 'required|string',
            'userDetails.lastName' => 'required|string',
            'userDetails.address' => 'required|string',
            'userDetails.apartment' => 'nullable|string',
            'userDetails.postalCode' => 'required|string',
            'userDetails.city' => 'required|string',
            'userDetails.phone' => 'nullable|string',
            'userDetails.deliveryMethod' => 'required|string|in:standard,express',
        ]);

        if ($validator->fails()) {
            $missingFields = array_keys($validator->errors()->toArray());
            $errorSentence = "The following fields are required: " . implode(', ', $missingFields);

            return response()->json([
                'success' => false,
                'error' => $errorSentence,
                'clientSecret' => null,
            ], 422);
        }
        Stripe::setApiKey(config('stripe.secret_key'));

        try {
            // Create PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->input('amount', 5000),
                'currency' => 'eur',
                'payment_method' => $request->input('paymentMethodId'),
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
            ]);

            if ($paymentIntent->status === 'succeeded') {
                $data = $request->input('userDetails');
                Contact::create([
                    'email' => $data['email'],
                    'first_name' => $data['firstName'],
                    'last_name' => $data['lastName'],
                    'address' => $data['address'],
                    'apartment_suite' => $data['apartment'],
                    'postal_code' => $data['postalCode'],
                    'city' => $data['city'],
                    'phone' => $data['phone'],
                    'delivery_method' => $data['deliveryMethod'],
                    'verified' => true,
                ]);

                return response()->json(['success' => 'Payment and data storage successful!']);
            } elseif ($paymentIntent->status === 'requires_action') {
                return response()->json(['clientSecret' => $paymentIntent->client_secret]);
            }

            return response()->json(['error' => 'Payment failed.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
