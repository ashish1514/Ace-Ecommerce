<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class BuyNowController extends Controller
{
    public function buyNow(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        $cart = Cart::where('user_id', auth()->id())
                    ->where('product_id', $product->id)
                    ->first();
        Session::forget('buy_now_product');
        Session::put('buy_now_product', [
            'product_id' => $product->id,
            'name'       => $product->name,
            'price'      => $product->price,
            'address'    => $product->address,
            'quantity'   => $cart->quantity,
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

    $request->validate([
        'address' => 'required|string|max:255',
    ]);

    $total = $product['price'] * $product['quantity'];

    $order = Order::create([
        'user_id' => Auth::id(),
        'total'   => $total,
        'address' => $request->input('address'),
        'status'  => 'complete'
    ]);

    OrderItem::create([
        'order_id'   => $order->id,
        'product_id' => $product['product_id'],
        'quantity'   => $product['quantity'],
        'address' => $request->input('address'),
        'price'      => $product['price'],
    ]);

    Session::forget('buy_now_product');

    return redirect()->route('home')->with('success', 'Order placed successfully!');
}

}
