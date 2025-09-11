<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Edit Product') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Form for edit produts') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <flux:button variant="primary" href="{{route('products.index')}}" color="red">Back</flux:button>

    <div class="w-150">
       <form wire:submit.prevent="submit" class="mt-6 space-y-6">
            <flux:input wire:model="name" label="Name" />
            <flux:textarea wire:model="detail" label="Detail" />
            <flux:button type="submit" variant="primary">Submit</flux:button>
        </form>
    </div>
</div>
