<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Edit Role') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Form for Edit roles') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <flux:button variant="primary" href="{{route('roles.index')}}" color="red">Back</flux:button>

    <div class="w-150">
        <form wire:submit.prevent="submit" class="mt-6 space-y-6">
            <flux:input wire:model="name" label="Name" />
            <flux:checkbox.group wire:model="permissions" label="permissions">
            <table style="width:100%; overflow: hidden;">
                    <tbody>
                        @foreach($allPermissions as $group => $permissions)
                            <tbody x-data="{ open: false }" class="border-b border-gray-200">
                                <tr class="cursor-pointer bg-gray-50" @click="open = !open">
                                    <td colspan="3" class="px-4 py-2">
                                        <div class="flex justify-between items-center font-bold">
                                            <b><span>{{ $group }}</span></b>
                                            <svg :class="{ 'rotate-90': open }" class="h-5 w-5 text-gray-500 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </div>
                                    </td>
                                </tr>
                                <tr x-show="open" x-transition x-cloak>
                                    <td colspan="3" class="p-0">
                                        <table class="w-full">
                                            <tbody>
                                                @foreach($allPermissions as $permission)
                                                    <tr class="border-t border-gray-100">
                                                        <td></td>
                                                        <td class="px-6 py-2">{{ $permission->name }}</td>
                                                        <td class="text-center">
                                                            <flux:checkbox
                                                                label=""
                                                                value="{{ $permission->name }}"
                                                            />
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        @endforeach
                    </tbody>
                </table>
            </flux:checkbox.group>
            <flux:button type="submit" variant="primary">Submit</flux:button>
        </form>
    </div>
</div>
