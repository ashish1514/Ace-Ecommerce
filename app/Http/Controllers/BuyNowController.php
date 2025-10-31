<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class BuyNowController extends Controller
{
    public function buyNow(Request $request)
    {
        return redirect()->route('buy.now.checkout', ['product_id' => $request->product_id]);
    }
    public function checkout(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        return view('checkout.buy_now', compact('product'));
    }
    public function placeOrder(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to place an order.');
        }        
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'address' => 'required|string',
            'full_name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $quantity = $validated['quantity'];

        $orderedQty = OrderItem::where('product_id', $product->id)
                        ->whereHas('order', function($q){
                            $q->where('status', 'complete');
                        })
                        ->sum('quantity');

        $remaining = $product->quantity - $orderedQty;

        if ($quantity > $remaining) {
            return back()->with('error', 'Only ' . $remaining . ' item(s) left in stock.');
        }

        $order = Order::create([
            'user_id'        => Auth::id(),
            'total'          => $product->price * $quantity,
            'address'        => $validated['address'],
            'status'         => 'complete',
            'full_name'      => $validated['full_name'],
            'email'          => $validated['email'],
            'phone'          => $validated['phone'],
            'city'           => $validated['city'],
            'postal_code'    => $validated['postal_code'],
            'payment_method' => $validated['payment_method'],
        ]);

        OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $product->id,
            'quantity'   => $quantity,
            'address'    => $validated['address'],
            'price'      => $product->price * $quantity,
        ]);

        return redirect()->route('home')->with('success', 'Order placed successfully!');
    }
}
