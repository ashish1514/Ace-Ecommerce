<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Create User') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Form for create users') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <flux:button variant="primary" href="{{route('users.index')}}" color="red">Back</flux:button>

    <div class="w-150">
        <form wire:submit.prevent="submit" class="mt-6 space-y-6">
            <flux:input wire:model="name" label="Name" />
            <flux:input wire:model="email" label="Email" />
            <flux:input type="password" wire:model="password" label="Password" />
            <flux:input type="password" wire:model="password_confirmation" label="Confirm Password" />
           <flux:checkbox.group wire:model="roles" label="Roles">
            @foreach($allRoles as $role)
            <flux:checkbox label="{{$role->name }}" value="{{$role->name }}"/>
            @endforeach
            </flux:checkbox.group>
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
