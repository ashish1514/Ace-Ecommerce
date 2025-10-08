<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class WishlistController extends Controller
{
    public function add(Request $request, $productId)
    {
        $user = Auth::user();
        $exists = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();

        if (!$exists) {
            Wishlist::create([
                'user_id' => $user->id,
                'product_id' => $productId,
            ]);
            session()->flash('success', 'Product added to wishlist successfully.');
        } else {
            session()->flash('info', 'Product is already in your wishlist.');
        }

        return redirect()->back();
    }

    public function remove(Request $request, $productId)
    {
        $user = Auth::user();

        $deleted = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->delete();

        if ($deleted) {
            session()->flash('success', 'Product removed from wishlist successfully.');
        } else {
            session()->flash('info', 'Product was not found in your wishlist.');
        }

        return redirect()->back();
    }

    public function addToCartAndRemove($productId, Request $request)
    {
        $product = Product::findOrFail($productId);

        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                'quantity' => 1,
                'name' => $product->name,
                'price' => $product->price,
            ];
        }

        session()->put('cart', $cart);

        $user = $request->user();
        $user->wishlist()->detach($productId); 

        return redirect()->route('wishlist.index')
            ->with('success', 'Product added to cart and removed from wishlist.');
    }



    public function index(Request $request)
    {
            if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Please log in first.');
    }

        $user = Auth::user();
        $wishlists = Wishlist::with('product')->where('user_id', $user->id)->get();

        $total = 0;
        $wishlistCount = 0;
        foreach ($wishlists as $wishlist) {
            if ($wishlist->product) {
                $total += $wishlist->product->price;
                $wishlistCount++;
            }
        }
        session(['wishlist_count' => $wishlistCount]);
        return view('wishlist.index', compact('wishlists', 'total', 'wishlistCount'));
    }
}
