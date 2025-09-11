<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;

class ProductIndex extends Component
{
    public function render()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('livewire.products.product-index',compact('products'));
    }
     public function delete($id)
    {   
        $products = Product::find($id);
        $products->delete();
        session()->flash("success", "Product deleted successfully");
        return redirect()->route('products.index');
        
    }
}
