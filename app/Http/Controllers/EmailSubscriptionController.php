<?php

namespace App\Http\Controllers;

use App\Mail\EmailSubscriptionConfirmation;
use App\Models\EmailSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Inertia\Inertia;
use function Termwind\render;

class EmailSubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:email_subscriptions,email',
        ], [
            'email.unique' => 'Vaša e-mailová adresa je už zaregistrovaná.',
        ]);


        $token = Str::random(126);

        $subscription = EmailSubscription::create([
            'email' => $request->input('email'),
            'token' => $token,
        ]);

        Mail::to($request->input('email'))->send(new EmailSubscriptionConfirmation($token));

        return response()->json(['message' => 'Skontrolujte si prosím svoj e-mail a potvrďte svoju registráciu na odber']);
    }
    public function confirm($token)
    {
        $subscription = EmailSubscription::where('token', $token)->first();

        if (!$subscription) {
            return response()->json(['error' => 'Neplatný token'], 400);
        }

        $subscription->is_confirmed = true;
        $subscription->save();

        return Inertia::render('EmailVerified');
    }
}
