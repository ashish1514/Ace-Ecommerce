@extends('frontend.layouts.frontend')
@section('content')
<main>
    <div class="main">
        <div class="banner mb-4">
            <img src="{{ asset('frontend/assets/banner/banner.jpg') }}" alt="Banner Image" class="img-fluid w-100">
        </div>
        <div class="container">
            <h2 class="mb-4 text-center">Products</h2>
            <div class="row">
                @forelse($products as $product)
                    <div class="col-md-4">
                        <div class="card h-100 shadow-sm d-flex flex-column">
                            <div class="text-center p-3 bg-light" style="height: 180px; display: flex; align-items: center; justify-content: center;">
                            @if($product->image)<img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 160px; object-fit: contain";>@endif
                        </div>
                        <div class="card-body">
                            <h6 class="card-title text-truncate" title="{{ $product->shortdescription}}">{{ $product->shortdescription}}</h6>
                        </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title text-truncate" title="{{ $product->name }}">{{ $product->name }}</h6>
                                <p class="card-text text-primary mb-2" style="font-size: 1.1rem;">
                                    $ {{ number_format($product->price, 2) }}
                                </p>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p>No products available.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</main>
@endsection
