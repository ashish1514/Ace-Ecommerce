<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Staff') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage all your staff members') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    @can('Staff Add')
        <flux:button variant="primary" href="{{ route('staff.create') }}">Create Staff</flux:button>
    @endcan

    <div class="overflow-x-auto mt-6">
        <table id="myCustomTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Email</th>
                    <th class="px-6 py-3">Department</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($staff as $member)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-dark">
                        <td class="px-6 py-2 text-black">{{ $member->name }}</td>
                        <td class="px-6 py-2 text-black">{{ $member->email }}</td>
                        <td class="px-6 py-2 text-black">
                            @if($member->department)
                                <flux:badge>{{ $member->department->name }}</flux:badge>
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>
                        <td class="px-6 py-2 text-black">
                            @if($member->status === 'Active')
                                <flux:badge class="bg-green-500 text-white" color="green">{{ ucfirst($member->status) }}</flux:badge>
                            @else
                                <flux:badge class="bg-red-500 text-white" color="red">{{ ucfirst($member->status) }}</flux:badge>
                            @endif
                        </td>
                        <td class="px-6 py-2 flex flex-wrap gap-2 items-center">
                            @can('Staff Edit')
                                <a href="{{ route('staff.edit', $member->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">Edit</a>
                            @endcan
                            @can('Staff Delete')
                                <button onclick="confirmDelete({{ $member->id }}, '{{ $member->name }}')" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg">Delete</button>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            No staff members found.
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
        });
    });
    function confirmDelete(staffId, staffName) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to delete " + staffName,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('delete', staffId);
            }
        });
    }

    document.addEventListener('livewire:staffDeleted', (event) => {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: event.detail.staffName + ' deleted successfully',
            showConfirmButton: false,
            timer: 3000
        });
    });
</script>
