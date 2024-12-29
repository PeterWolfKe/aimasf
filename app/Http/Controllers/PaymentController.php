<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        Stripe::setApiKey(config('stripe.secret_key'));
        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $request->input('amount', 5000),
                'currency' => 'eur',
            ]);

            return response()->json(['clientSecret' => $paymentIntent->client_secret]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
