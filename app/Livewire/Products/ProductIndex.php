<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;

class ProductIndex extends Component
{
    protected $listeners = ['deleteProduct' => 'delete'];

    public function render()
    {
        $products = Product::orderBy('id', 'desc')->get();
        return view('livewire.products.product-index', compact('products'));
    }

    public function delete($id)
    {   
        $product = Product::find($id);
        $product->delete();
        session()->flash("success", "Product deleted successfully");
        $this->dispatch('Productdeleted', productname: $product->name);
        return redirect()->route('products.index');
    }
}
