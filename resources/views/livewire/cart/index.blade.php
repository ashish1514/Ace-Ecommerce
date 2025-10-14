@extends('frontend.layouts.frontend')
@section('content')
<style>
.container { margin: 4%; }
.table-img { max-height: 80px;object-fit: contain;}
</style>

<div class="container py-4">
    <h2 class="mb-4">Your Chart</h2>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(count($cartItems) > 0)
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Image</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartItems as $item)
                        <tr>
                            <td>{{ $item['product']->name }}</td>
                            <td>
                                <img 
                                    src="{{ asset('storage/' . $item['product']->image) }}" 
                                    alt="{{ $item['product']->name }}" 
                                    class="img-thumbnail" 
                                    style="height: 40px; width: 40px; object-fit: cover;"
                                    onerror="this.onerror=null;this.src='{{ asset('images/default-product.png') }}';"
                                >
                            </td>
                            <td>₹{{ number_format($item['product']->price, 2) }}</td>
                            <td>
                                <form action="{{ route('cart.update', $item['product']->id) }}" method="POST" class="d-flex" style= "width:100px">
                                    @csrf
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min= "0" class="form-control form-control-sm" onchange="this.form.submit()">
                                </form>
                            </td>
                            <td>₹{{ number_format($item['product']->price * $item['quantity'], 2) }}</td>
                            <td>
                            <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger mb-2">Remove</button>
                            </form>
                            <form action="{{ route('buy.now') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                            <button type="submit" class="btn btn-sm btn-success">Buy Now</button>
                            </form>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="4" class="text-end"><strong>Total:</strong></td>
                        <td colspan="2"><strong>₹{{ number_format($total, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        @else
            <div class="text-center">
                Your cart is empty.
            </div>
        @endif
    <a href="{{ route('home') }}" class="btn btn-secondary mt-3">Continue Shopping</a>
</div>
@endsection
