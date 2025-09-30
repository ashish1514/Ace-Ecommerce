<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductGallery;

class ProductCreate extends Component
{
    use WithFileUploads;

    public $name, $description, $shortdescription, $status = 'Active', $price;
    public $category_id;
    public $image;
    public $gallery_temp = []; 

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'shortdescription' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:1024', 
            'gallery_temp.*' => 'nullable|image|max:2048',
            'status' => 'required|in:Active,Inactive',
            'category_id' => 'required|exists:categories,id',
        ]);

        $imagePath = $this->image ? $this->image->store('products', 'public') : null;

        $product = Product::create([
            'name' => $this->name,
            'description' => $this->description,
            'shortdescription' => $this->shortdescription,
            'price' => $this->price,
            'image' => $imagePath,
            'status' => $this->status,
            'category_id' => $this->category_id,
        ]);

        if ($this->gallery_temp && count($this->gallery_temp)) {
            foreach ($this->gallery_temp as $galleryImage) {
                $galleryPath = $galleryImage->store('products/gallery', 'public');

                ProductGallery::create([
                    'product_id' => $product->id,
                    'image' => $galleryPath,
                ]);
            }
        }

        session()->flash('message', 'Product created successfully.');

        return redirect()->route('products.index');
    }

    public function render()
    {
        return view('livewire.products.product-create', [
            'categories' => Category::all(),
        ]);
    }
}
