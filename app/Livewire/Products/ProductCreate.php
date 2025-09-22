<?php

namespace App\Livewire\Products;


use Livewire\Component;
use App\Models\Product;

class ProductCreate extends Component
{

    public $name, $detail;
    public $status = 'Active';

    public function submit()
    {
        $this->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        Product::create([
            'name' => $this->name,
            'detail' => $this->detail,
            'status' => $this->status,
        ]);
        session()->flash('success', 'Product created successfully.');
        return redirect()->route('products.index');
    }
    public function render()
    {
        return view('livewire.products.product-create');
    }
}
