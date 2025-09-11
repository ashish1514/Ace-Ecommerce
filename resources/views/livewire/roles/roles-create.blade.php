<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Create Role') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Form for create roles') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <flux:button variant="primary" href="{{route('roles.index')}}" color="red">Back</flux:button>

    <div class="w-150">
        <form wire:submit.prevent="submit" class="mt-6 space-y-6">
            <flux:input wire:model="name" label="Name" />
            <flux:checkbox.group wire:model="permissions" label="permissions">
            @foreach($allPermissions as $permission)
            <flux:checkbox label="{{$permission->name }}" value="{{$permission->name }}"/>
            @endforeach
            </flux:checkbox.group>
            <flux:button type="submit" variant="primary">Submit</flux:button>
        </form>
    </div>
</div>
