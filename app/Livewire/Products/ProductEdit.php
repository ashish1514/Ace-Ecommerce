<?php

namespace App\Livewire\Products;

use Livewire\Component;
use App\Models\Product;

class ProductEdit extends Component
{
    public $product;
    public $name, $detail;
     public function mount($id)
    {
        $this->product = Product::find($id);
        $this->name = $this->product->name;
        $this->detail = $this->product->detail;
    }
      public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'detail' => 'required',
        ]);
        $this->product->name = $this->name;
        $this->product->detail = $this->detail;
        $this->product->save();
        session()->flash('success', 'Product Edit  successfully.');
        return redirect()->route('products.index');
    }

    public function render()
    {
        return view('livewire.products.product-edit');
    }
}
