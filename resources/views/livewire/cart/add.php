<form action="{{ route('cart.add', $product->id) }}" method="POST">
    @csrf
    <button type="submit" class="btn btn-primary">
        Add to Cart
    </button>
</form>
