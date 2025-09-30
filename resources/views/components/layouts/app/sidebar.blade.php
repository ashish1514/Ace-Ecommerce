<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    
                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>    
                @if(auth()->user()->can('User Add') ||
                    auth()->user()->can('User Edit') ||
                    auth()->user()->can('User Delete') ||
                    auth()->user()->can('User Show'))
                    <flux:navlist.item icon="users" :href="route('users.index')" :current="request()->routeIs('users.index')" wire:navigate>{{ __('Users') }}</flux:navlist.item>
                   @endif
                    @if(auth()->user()->can('Role Add') ||
                    auth()->user()->can('Role Edit') ||
                    auth()->user()->can('Role Delete') ||
                    auth()->user()->can('Role Show'))
                    <flux:navlist.item icon="link-slash" :href="route('roles.index')" :current="request()->routeIs('roles.index')" wire:navigate>{{ __('Roles') }}</flux:navlist.item>
                    @endif
                    @if(auth()->user()->can('Product Add') ||
                    auth()->user()->can('Product Edit') ||
                    auth()->user()->can('Product Delete'))
                    <flux:navlist.item icon="cube" :href="route('products.index')" :current="request()->routeIs('products.index')" wire:navigate>{{ __('Products') }}</flux:navlist.item>
                    @endif
                    @if(auth()->user()->can('Category Add') || auth()->user()->can('Category Edit') || auth()->user()->can('Category Delete'))
                        <flux:navlist.item icon="bars-3" :href="route('category.index')" :current="request()->routeIs('category.index')" wire:navigate>
                            {{ __('Category') }}
                        </flux:navlist.item>
                    @endif
                
                    @if(auth()->user()->can('Staff Add') ||
                    auth()->user()->can('Staff Edit') ||
                    auth()->user()->can('Staff Delete') ||
                    auth()->user()->can('Staff Show'))
                    <flux:navlist.item icon="user" :href="route('staff.index')" :current="request()->routeIs('staff.index')" wire:navigate>{{ __('Staff') }}</flux:navlist.item>
                    @endif
                </flux:navlist.group>
            </flux:navlist>
            <flux:spacer />
        </flux:sidebar>
        {{ $slot }}

        @fluxScripts
    </body>
</html>
