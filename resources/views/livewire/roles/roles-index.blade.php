<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Roles') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage all your users roles') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
@if (session('success'))
    <div class="mb-4 rounded-md bg-green-100 border border-green-400 text-green-700 px-4 py-3" style="background: #00a63e;" color="green">
        {{ session('success') }}
    </div>
@endif

@can('role.create')
    <flux:button variant="primary" href="{{ route('roles.create') }}">Create Role</flux:button>
    @endcan
    <div class="overflow-x-auto mt-6">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Permissions</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
           <tbody>
                @forelse ($roles as $role)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800">
                        <td class="px-6 py-2 text-gray-900 dark:text-white">{{ $role->id }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $role->name }}</td>
                        <td class="px-6 py-2">
                            <div class="flex flex-wrap gap-2">
                                @foreach($role->permissions as $permission)
                                    <flux:badge>{{ $permission->name }}</flux:badge>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-2">
                            <div class="flex space-x-2">
                              @can('role.show') <a href="{{ route('roles.show', $role->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg mr-2">Show</a>@endcan
                                @can('role.edit')<a href="{{ route('roles.edit', $role->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg mr-2">Edit</a>@endcan
                                @can('role.delete')<button wire:click="delete({{ $role->id }})" type="submit" wire:confirm="Are you sure to remove this user?" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg">Delete</button>@endcan
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            No roles found.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>
</div>
