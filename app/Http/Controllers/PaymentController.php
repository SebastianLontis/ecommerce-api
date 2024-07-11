<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function createPaymentIntent(Request $request)
    {
        $request->validate([
            'amount' => 'required|integer',
            'currency' => 'nullable|string|size:3',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        $currency = $request->currency ?: config('app.currency', 'usd');

        $paymentIntent = PaymentIntent::create([
            'amount' => $request->amount,
            'currency' => $currency,
            'automatic_payment_methods' => [
                'enabled' => true,
                'allow_redirects' => 'never', 
            ],
        ]);
  
        return response()->json($paymentIntent);
    }

    public function confirmPaymentIntent(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::retrieve($request->payment_intent_id);
            $paymentIntent->confirm([
                'payment_method' => $request->payment_method,
            ]);

            return response()->json(['message' => 'Payment successfully processed']);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
