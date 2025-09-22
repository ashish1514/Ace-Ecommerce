<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Create Product') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Form for create produts') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <flux:button variant="primary" href="{{route('products.index')}}" color="red">Back</flux:button>
    <div class="col-span-2 ">
        <form wire:submit.prevent="submit" class="mt-6 space-y-6">
            <flux:input wire:model="name" label="Name" class="col-span-2 "/>
            <flux:textarea wire:model="detail" label="Detail" />
            <div class="mb-4">
                <label for="status" class="block mb-2 font-medium">Status</label>
                <select wire:model="status" id="status" class="w-full border-gray-300 rounded">
                    <option value="Active">Active</option>
                    <option value="Inactive">Inactive</option>
                </select>
            </div>
            <flux:button type="submit" variant="primary">Submit</flux:button>
        </form>
    </div>
</div>

