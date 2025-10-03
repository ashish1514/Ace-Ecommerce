@extends('frontend.layouts.frontend')
@section('content')
<main>
    <div class="main">
        <div class="banner mb-4">
            <img src="{{ asset('frontend/assets/banner/banner.jpg') }}" alt="Banner Image" class="img-fluid w-100">
        </div>
        <div class="container">
            <h2 class="mb-5 text-center fw-bold" style="letter-spacing: 2px; color: #333;">Our Products</h2>
            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-12 col-sm-6 col-md-4 d-flex">
                        <div class="card flex-fill border-0 shadow-lg rounded-4 overflow-hidden">
                            <div class="bg-white d-flex align-items-center justify-content-center" style="height: 220px;">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 180px; object-fit: contain;">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column p-4">
                                <h6 class="card-subtitle mb-2 text-muted text-truncate" title="{{ $product->shortdescription }}">
                                    {{ $product->shortdescription }}
                                </h6>
                                <h5 class="card-title mb-3 text-truncate" title="{{ $product->name }}">
                                    <a href="{{ route('products.show', $product->id) }}" class="stretched-link text-decoration-none text-dark fw-semibold">
                                        {{ $product->name }}
                                    </a>
                                </h5>
                                <div class="mb-3">
                                    <span class="badge bg-primary fs-6 py-2 px-3" style="font-size: 1.1rem;">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                </div>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fw-bold shadow-sm">
                                        <i class="bi bi-cart-plus me-2"></i>Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted fs-4">No products available.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</main>
@endsection
