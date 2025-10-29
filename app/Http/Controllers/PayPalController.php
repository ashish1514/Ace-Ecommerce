<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Product;

class PayPalController extends Controller
{
    // Start PayPal payment
    public function payment(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;
        $total = $product->price * $quantity;

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "USD",
                    "value" => number_format($total, 2, '.', ''),
                ],
                "description" => $product->name,
            ]],
            "application_context" => [
                "return_url" => route('paypal.payment.success', ['product_id' => $product->id, 'quantity' => $quantity]),
                "cancel_url" => route('paypal.payment.cancel'),
            ],
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] == 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        }

        return redirect()->route('home')->with('error', 'Something went wrong.');
    }

    // Payment canceled
    public function paymentCancel()
    {
        return redirect()->route('home')->with('error', 'You canceled the payment.');
    }

    // Payment success
    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            return redirect()->route('home')->with('success', 'Payment completed successfully!');
        }

        return redirect()->route('home')->with('error', 'Payment failed.');
    }
}
