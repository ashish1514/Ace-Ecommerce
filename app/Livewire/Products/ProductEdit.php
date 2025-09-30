<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductGallery;
use Illuminate\Support\Facades\Storage;

class ProductEdit extends Component
{
    use WithFileUploads;

    public $product;
    public $name, $description, $shortdescription, $price, $image, $category_id, $oldImage, $oldImageUrl;
    public $status;
    public $categories;
    public $gallery_temp = [];
    public $oldGallery = [];
    public $oldGalleryUrls = [];

    public function mount($id)
    {
        $this->product = Product::findOrFail($id);
        $this->name = $this->product->name;
        $this->description = $this->product->description;
        $this->shortdescription = $this->product->shortdescription;
        $this->price = $this->product->price;
        $this->category_id = $this->product->category_id;
        $this->status = $this->product->status;
        $this->oldImage = $this->product->image;
        $this->oldImageUrl = $this->oldImage ? asset('storage/' . $this->oldImage) : null;
        $this->categories = Category::all();
        $this->oldGallery = $this->product->galleries ? $this->product->galleries->pluck('image', 'id')->toArray() : [];
        $this->oldGalleryUrls = [];
        foreach ($this->oldGallery as $id => $img) {
            $this->oldGalleryUrls[$id] = asset('storage/' . $img);
        }
    }

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

        $this->product->name = $this->name;
        $this->product->description = $this->description;
        $this->product->shortdescription = $this->shortdescription;
        $this->product->price = $this->price;
        $this->product->status = $this->status;
        $this->product->category_id = $this->category_id;

        if ($this->image) {
            if ($this->oldImage && Storage::disk('public')->exists($this->oldImage)) {
                Storage::disk('public')->delete($this->oldImage);
            }
            $imageName = $this->image->store('products', 'public');
            $this->product->image = $imageName;
        } else {
            $this->product->image = $this->oldImage;
        }

        $this->product->save();

        if ($this->gallery_temp && is_array($this->gallery_temp)) {
            foreach ($this->gallery_temp as $galleryImage) {
                $galleryPath = $galleryImage->store('products/gallery', 'public');
                ProductGallery::create([
                    'product_id' => $this->product->id,
                    'image' => $galleryPath,
                ]);
            }
        }

        session()->flash('message', 'Product edited successfully.');

        return redirect()->route('products.index');
    }

    public function removeGalleryImage($index)
    {
        if (isset($this->gallery_temp[$index])) {
            unset($this->gallery_temp[$index]);
            $this->gallery_temp = array_values($this->gallery_temp);
        }
    }

    public function render()
    {
        return view('livewire.products.product-edit', [
            'categories' => $this->categories,
            'oldGalleryUrls' => $this->oldGalleryUrls,
        ]);
    }
}
