<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Show User') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('This page is for show user') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <flux:button variant="primary" href="{{route('users.index')}}" color="red">Back</flux:button>

    <div class="w-150">
        <p class="mt-2"><strong>Name: </strong>{{$user->name }}</p>
        <p class="mt-2"><strong>Email: </strong>{{$user->email }}</p>
    </div>
</div>
