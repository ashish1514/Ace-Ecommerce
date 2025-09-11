<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Users') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage all your users') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>

    @if (session('success'))
        <div class="mb-4 rounded-md border border-green-400 text-white px-4 py-3" style="background: #00a63e;">
            {{ session('success') }}
        </div>
    @endif

    @can('user.create')
        <flux:button variant="primary" href="{{ route('users.create') }}">Create User</flux:button>
    @endcan

    <div class="overflow-x-auto mt-6">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3">ID</th>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Roles</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800">
                        <td class="px-6 py-2 text-gray-900 dark:text-white">{{ $user->id }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $user->name }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $user->email }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">
                            <div class="flex flex-wrap gap-2">
                                @foreach($user->roles as $role)
                                    <flux:badge>{{ $role->name }}</flux:badge>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-2 flex flex-wrap gap-2 items-center">
                            @can('user.show')
                                <a href="{{ route('users.show', $user->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg">Show</a>
                            @endcan

                            @can('user.edit')
                                <a href="{{ route('users.edit', $user->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">Edit</a>
                            @endcan

                            @can('user.delete')
                                <form method="POST" onsubmit="return confirm('Are you sure to remove this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button wire:click="delete({{ $user->id }})"
                                            type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg">
                                        Delete
                                    </button>
                                </form>
                            @endcan

                            <form method="POST" action="{{ route('admin.switchUser', $user->id) }}">
                                @csrf
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg">
                                    Switch
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            No users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


