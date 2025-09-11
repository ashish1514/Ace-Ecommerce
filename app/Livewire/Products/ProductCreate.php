<?php

namespace App\Livewire\Products;


use Livewire\Component;
use App\Models\Product;

class ProductCreate extends Component
{

    public $name, $detail;

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'detail' => 'required|string|max:255',
        ]);

        Product::create([
            'name' => $this->name,
            'detail' => $this->detail,
        ]);

        session()->flash('success', 'Product created successfully.');

        return redirect()->route('products.index');
    }
    public function render()
    {
        return view('livewire.products.product-create');
    }
}
