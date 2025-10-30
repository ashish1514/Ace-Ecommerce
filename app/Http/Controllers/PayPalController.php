<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    public function payWithPayPal(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
            'full_name'  => 'required|string',
            'email'      => 'required|email',
            'phone'      => 'required|string',
            'address'    => 'required|string',
            'city'       => 'required|string',
            'postal_code'=> 'required|string',
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $order = $provider->createOrder([
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "amount" => [
                    "currency_code" => "USD",
                    "value" => number_format($product->price * $quantity, 2, '.', '')
                ]
            ]],
            "application_context" => [
                "cancel_url" => route('paypal.cancel'),
                "return_url" => route('paypal.success') . '?' . http_build_query($request->all())
            ]
        ]);

        return redirect($order['links'][1]['href']);
    }

    public function paymentSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $product = Product::findOrFail($request->product_id);
            $quantity = $request->quantity;

            $order = Order::create([
                'user_id'        => Auth::id(),
                'total'          => $product->price * $quantity,
                'address'        => $request->address,
                'status'         => 'complete',
                'full_name'      => $request->full_name,
                'email'          => $request->email,
                'phone'          => $request->phone,
                'city'           => $request->city,
                'postal_code'    => $request->postal_code,
                'payment_method' => 'paypal',
            ]);

            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $product->id,
                'quantity'   => $quantity,
                'address'    => $request->address,
                'price'      => $product->price * $quantity,
            ]);

            return redirect()->route('home')->with('success', 'Payment completed successfully!');
        }

        return redirect()->route('home')->with('error', 'Payment failed.');
    }

    public function paymentCancel()
    {
        return redirect()->route('home')->with('error', 'Payment was cancelled.');
    }
}
