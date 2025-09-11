<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Show Product Detail') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('This page is for show product details') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <flux:button variant="primary" href="{{route('products.index')}}" color="red">Back</flux:button>

    <div class="w-150">
        <p class="mt-2"><strong>Name: </strong>{{$product->name }}</p>
        <p class="mt-2"><strong>Detail: </strong>{{$product->detail }}</p>
    </div>
</div>
    