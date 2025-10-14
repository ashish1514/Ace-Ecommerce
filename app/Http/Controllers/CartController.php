<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $cartItems = Cart::with('product') 
            ->where('user_id', $user->id)
            ->get();

        $total = $cartItems->sum(function ($item) {
            return optional($item->product)->price * $item->quantity;
        });
      
        return view('livewire.cart.index', compact('cartItems', 'total'));
    }

   public function add(Request $request, $id)
    {
        $user = Auth::user();
        $product = Product::findOrFail($id);

        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($cartItem) {
            if ($cartItem->quantity >= $product->quantity) {
                return redirect()->back()->with('warning', 'Not enough stock available');
            }

            $cartItem->increment('quantity');
        } else {
            Cart::create([
                'user_id'    => $user->id,
                'product_id' => $product->id,
                'quantity'   => 1,
            ]);
        }

        $cartCount = Cart::where('user_id', $user->id)->count();

        if ($request->ajax()) {
            return response()->json([
                'status'     => 'success',
                'message'    => 'Product added to cart!',
                'cart_count' => $cartCount,
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }


    public function remove(Request $request, $id)
    {
        $user = Auth::user();

        Cart::where('user_id', $user->id)
            ->where('product_id', $id)
            ->delete();

        $cartCount = Cart::where('user_id', $user->id)->count();
      
        if ($request->ajax()) {
            return response()->json([
                'status'     => 'success',
                'message'    => 'Product removed from cart!',
                'cart_count' => $cartCount,
            ]);
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }

     public function update(Request $request, $id)
{
    $request->validate([
        'quantity' => 'required|integer|min:0',
    ]);

    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login')->with('warning', 'Please log in to update your cart.');
    }
    $product = Product::find($id);
    $quantity = (int) $request->input('quantity');

    if ($quantity > $product->quantity) {
        return redirect()->back()->with('warning', 'Requested quantity exceeds available stock.');
    }

    if ($quantity == 0) {
        Cart::where('user_id', $user->id)
            ->where('product_id', $id)
            ->delete();

        $message = 'Product removed from cart.';

        if ($request->ajax()) {
            return response()->json([
                'status' => 'success',
                'message' => $message,
                'cart_count' => Cart::where('user_id', $user->id)->count(),
            ]);
        }

        return redirect()->back()->with('success', $message);
    }

    $cartItem = Cart::where('user_id', $user->id)
        ->where('product_id', $id)
        ->first();

    $cartItem->update(['quantity' => $quantity]);

    if ($request->ajax()) {
        return response()->json([
            'status' => 'success',
            'message' => 'Cart updated!',
            'cart_count' => Cart::where('user_id', $user->id)->count(),
        ]);
    }

    return redirect()->back()->with('success', 'Cart updated!');
}

}
