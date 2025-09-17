<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Users') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage all your users') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    @can('User Add')
        <flux:button variant="primary" href="{{ route('users.create') }}">Create User</flux:button>
    @endcan

    <div class="overflow-x-auto mt-6">
        <table id="myCustomTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
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
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-dark">
                        <td class="px-6 py-2 text-black">{{ $user->id }}</td>
                        <td class="px-6 py-2 text-black">{{ $user->name }}</td>
                        <td class="px-6 py-2 text-black">{{ $user->email }}</td>
                        <td class="px-6 py-2 text-black">
                            <div class="flex flex-wrap gap-2">
                                @foreach($user->roles as $role)
                                    <flux:badge>{{ $role->name }}</flux:badge>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-2 flex flex-wrap gap-2 items-center">
                            @can('User Show')<a href="{{ route('users.show', $user->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg">Show</a>@endcan
                            @can('User Edit')<a href="{{ route('users.edit', $user->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">Edit</a>@endcan
                            @can('User Delete')<button onclick="confirmDelete({{ $user->id }}, '{{ $user->name }}')" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg">Delete</button>@endcan

                            @if(auth()->user()->is_admin)
                            <form method="POST" action="{{ route('admin.switchUser', $user->id) }}">
                                @csrf
                                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg">
                                    Switch
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            No users found..
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#myCustomTable').DataTable({
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'roles', name: 'roles' },
                { data: 'action', name: 'action', orderable: true, searchable: true }
            ]
        });
    });
    function confirmDelete(userId, userName) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to delete " + userName,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('delete', userId);
            }
        });
    }

    document.addEventListener('livewire:userDeleted', (event) => {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: event.detail.userName + ' deleted successfully',
            showConfirmButton: false,
            timer: 3000
        });
    });
</script>
