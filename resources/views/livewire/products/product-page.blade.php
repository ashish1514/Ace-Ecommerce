@extends('frontend.layouts.frontend')

@section('content')
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-6 mb-4">
            <img src="{{ $main_image ? asset('storage/' . $main_image) : asset('frontend/assets/images/') }}" 
                 alt="{{ $product->name ?? 'Product Image' }}" 
                 class="img-fluid border rounded mb-2" 
                 style="max-height: 400px; object-fit: contain; width: 100%;">

            @if(!empty($gallery_images))
                <div class="d-flex flex-wrap gap-2">
                    @foreach($gallery_images as $image)
                        <img src="{{ asset('storage/' . $image) }}" 
                             alt="Gallery Image" 
                             style="width: 60px; height: 60px; object-fit: cover;" 
                             class="border rounded">
                    @endforeach
                </div>
            @endif
        </div>

        <div class="col-md-6">
            <h3>{{ $product->name }}</h3>

            <p class="text-success fs-5">
                @if(isset($product->price))
                    ${{ number_format($product->price, 2) }}
                @else
                    <span class="text-muted">No price available</span>
                @endif
            </p>

            <p>
                <strong>Category:</strong> {{ $product->category->name }}<br>
                <strong>Status:</strong>
                @if(!empty($product->status))
                    <span class="text-success">Active</span>
                @else
                    <span class="text-danger">Inactive</span>
                @endif
            </p>

            <p>{{ $product->description ?? 'No description provided.' }}</p>

            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Add to Cart</button>
            </form>
        </div>
    </div>
</div>
@endsection
