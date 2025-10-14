<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class BuyNowController extends Controller
{
    public function buyNow(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        Session::forget('buy_now_product');
        Session::put('buy_now_product', [
            'product_id' => $product->id,
            'name'       => $product->name,
            'price'      => $product->price,
            'quantity'   => 1
        ]);

        return redirect()->route('buy.now.checkout');
    }

    public function checkout()
    {
        $product = Session::get('buy_now_product');

        if (!$product) {
            return redirect()->back()->with('error', 'No product selected for Buy Now.');
        }

        return view('checkout.buy_now', compact('product'));
    }

    public function placeOrder(Request $request)
    {
        $product = Session::get('buy_now_product');

        if (!$product) {
            return redirect()->route('home')->with('error', 'No product in session.');
        }

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to place an order.');
        }

        $total = $product['price'] * $product['quantity'];
 
        $order = Order::create([
            'user_id' => Auth::id(),
            'total'   => $total,
            'status'  => 'Compelete'
        ]);
      

        OrderItem::create([
            'order_id'   => $order->id,
            'product_id' => $product['product_id'],
            'quantity'   => $product['quantity'],
            'price'      => $product['price'],
        ]);

        Session::forget('buy_now_product');

        return redirect()->route('home')->with('success', 'Order placed successfully!');
    }
}
