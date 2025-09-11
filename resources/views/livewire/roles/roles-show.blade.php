<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Show Roles') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('This page is for show roles') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <flux:button variant="primary" href="{{route('roles.index')}}" color="red">Back</flux:button>

    <div class="w-150">
        <p class="mt-2"><strong>Name: </strong>{{$role->name }}</p>
        <p class="mt-2"><strong>Permission: </strong>
        @foreach($role->permissions as $permission)
        <flux:badge>{{ $permission->name }}</flux:badge>
        @endforeach
        </p>
    </div>
</div>
    