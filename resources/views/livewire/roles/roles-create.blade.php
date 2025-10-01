<div>
    <div class="row mb-4">
        <div class="col-12">
            <flux:heading size="xl" level="1">{{ __('Create Role') }}</flux:heading>
            <flux:subheading size="lg" class="mb-3">{{ __('Form for create roles') }}</flux:subheading>
            <flux:separator variant="subtle" />
        </div>
    </div>

    <div class="mb-3">
        <flux:button variant="primary" href="{{ route('roles.index') }}" color="red">Back</flux:button>
    </div>

    <div class="container">
        <form wire:submit.prevent="submit" class="mt-4" autocomplete="off">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <flux:input wire:model.defer="name" label="Name" id="name" required />
                    @error('name') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label fw-medium">Status</label>
                    <select wire:model="status" id="status" class="form-select" required>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                    </select>
                    @error('status') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <flux:checkbox.group wire:model="permissions" label="Permissions">
                            <div class="mb-2">
                                <input 
                                    type="checkbox" 
                                    id="selectAll" 
                                    class="form-check-input"
                                    {{-- Laravel/Livewire: select all via wire:click --}}
                                    wire:click="
                                        $set('permissions', 
                                            {{ collect($groupedPermissions)->flatten(1)->pluck('name')->map(fn($n) => (string)$n)->toJson() }}
                                        )
                                    "
                                    {{-- checked if all permissions are selected --}}
                                    @if(collect($groupedPermissions)->flatten(1)->pluck('name')->diff($permissions ?? [])->isEmpty())
                                        checked
                                    @endif
                                >
                                <label for="selectAll" class="form-check-label ms-2 fw-medium">Select All Permissions</label>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                        @foreach($groupedPermissions as $group => $permissionsGroup)
                                            <tbody class="border-bottom">
                                                <tr class="table-light">
                                                    <td colspan="3" class="px-3 py-2">
                                                        <div class="d-flex justify-content-between align-items-center fw-bold">
                                                            <div class="d-flex align-items-center gap-2">
                                                                <input 
                                                                    type="checkbox"
                                                                    class="form-check-input"
                                                                    {{-- Laravel/Livewire: select all in group --}}
                                                                    wire:click="
                                                                        $set('permissions', 
                                                                            (
                                                                                collect($permissions ?? [])->diff({{ Js::from($permissionsGroup->pluck('name')) }}).merge(
                                                                                    collect($permissions ?? [])->intersect({{ Js::from($permissionsGroup->pluck('name')) }}).count() === {{ count($permissionsGroup) }}
                                                                                        ? []
                                                                                        : {{ Js::from($permissionsGroup->pluck('name')) }}
                                                                                ).unique().values()
                                                                            )
                                                                        )
                                                                    "
                                                                    {{-- checked if all in group are selected --}}
                                                                    @if(collect($permissionsGroup->pluck('name'))->diff($permissions ?? [])->isEmpty())
                                                                        checked
                                                                    @endif
                                                                >
                                                                <b><span>{{ ucfirst($group) }}</span></b>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="3" class="p-0">
                                                        <table class="table mb-0">
                                                            <tbody>
                                                                @foreach($permissionsGroup as $permission)
                                                                    <tr class="border-top">
                                                                        <td style="width:30px;"></td>
                                                                        <td class="px-3 py-2">{{ $permission->name }}</td>
                                                                        <td class="text-center" style="width:50px;">
                                                                            <input
                                                                                type="checkbox"
                                                                                value="{{ $permission->name }}"
                                                                                wire:model="permissions"
                                                                                class="form-check-input"
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
                            </div>
                        </flux:checkbox.group>
                        @error('permissions') <div class="text-danger mt-1">{{ $message }}</div> @enderror
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 d-flex justify-content-end">
                    <flux:button type="submit" variant="primary">Submit</flux:button>
                </div>
            </div>
        </form>
    </div>
</div>
