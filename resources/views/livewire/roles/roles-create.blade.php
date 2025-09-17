<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Create Role') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Form for create roles') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    <flux:button variant="primary" href="{{ route('roles.index') }}" color="red">Back</flux:button>

    <div class="w-150" x-data="permissionManager(@entangle('permissions'))">
        <form wire:submit.prevent="submit" class="mt-6 space-y-6">
            <flux:input wire:model="name" label="Name" />

            <flux:checkbox.group wire:model="permissions" label="Permissions">
                <div class="mb-4">
                    <input type="checkbox" id="selectAll" @change="toggleAll($event)">
                    <label for="selectAll"><strong>Select All Permissions</strong></label>
                </div>

                <table style="width:100%; overflow: hidden;">
                    <tbody>
                        @foreach($groupedPermissions as $group => $permissions)
                            <tbody x-data="{ open: false }" class="border-b border-gray-200">
                                <tr class="cursor-pointer bg-gray-50" @click="open = !open">
                                    <td colspan="3" class="px-4 py-2">
                                        <div class="flex justify-between items-center font-bold">
                                            <div class="flex items-center space-x-2">
                                                <input type="checkbox"
                                                    :checked="areAllInGroupSelected({{ Js::from($permissions->pluck('name')) }})"
                                                    @click.stop="toggleGroup({{ Js::from($permissions->pluck('name')) }})"
                                                >
                                                <b><span>{{ $group }}</span></b>
                                            </div>
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
                                                @foreach($permissions as $permission)
                                                    <tr class="border-t border-gray-100">
                                                        <td></td>
                                                        <td class="px-6 py-2">{{ $permission->name }}</td>
                                                        <td class="text-center">
                                                            <input
                                                                type="checkbox"
                                                                value="{{ $permission->name }}"
                                                                x-model="selectedPermissions"
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

<script>
    function permissionManager(livewirePermissions) {
        return {
            selectedPermissions: livewirePermissions,

            toggleAll(event) {
                const allPermissions = Array.from(document.querySelectorAll('input[type="checkbox"][x-model="selectedPermissions"]')).map(el => el.value);
                if (event.target.checked) {
                    this.selectedPermissions = allPermissions;
                } else {
                    this.selectedPermissions = [];
                }

                this.$nextTick(() => this.updateSelectAllCheckbox());
            },

            toggleGroup(groupPermissions) {
                const allSelected = groupPermissions.every(p => this.selectedPermissions.includes(p));

                if (allSelected) {
                    this.selectedPermissions = this.selectedPermissions.filter(p => !groupPermissions.includes(p));
                } else {
                    this.selectedPermissions = Array.from(new Set([...this.selectedPermissions, ...groupPermissions]));
                }

                this.$nextTick(() => this.updateSelectAllCheckbox());
            },

            areAllInGroupSelected(groupPermissions) {
                return groupPermissions.every(p => this.selectedPermissions.includes(p));
            },

            updateSelectAllCheckbox() {
                const allCheckboxes = Array.from(document.querySelectorAll('input[type="checkbox"][x-model="selectedPermissions"]'));
                const allValues = allCheckboxes.map(cb => cb.value);

                const selectAllCheckbox = document.getElementById('selectAll');

                if (this.selectedPermissions.length === allValues.length) {
                    selectAllCheckbox.checked = true;
                } else {
                    selectAllCheckbox.checked = false;
                }
            }
        }
    }
</script>

