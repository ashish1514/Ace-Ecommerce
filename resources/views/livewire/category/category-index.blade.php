<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Category') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage all your categories') }}</flux:subheading>
        
        @can('Category Add')
            <flux:button variant="primary" href="{{ route('category.create') }}">
                {{ __('Create Category') }}
            </flux:button>
        @endcan
    </div>

    <div class="overflow-x-auto mt-6">
        <table id="categoryTable" class="w-full text-black">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Image</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="px-6 py-4 text-black">{{ $category->name }}</td>
                        <td class="px-6 py-4 text-black">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="h-10 w-auto object-cover rounded" onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';" />
                            @else
                                -
                            @endif
                        </td>
                        <td class="px-6 py-2 text-black">
                            @if(strtolower($category->status) === 'active')
                                <flux:badge class="bg-green-500 text-white" color="green">{{ ucfirst($category->status) }}</flux:badge>
                            @else
                                <flux:badge class="bg-red-500 text-white" color="red">{{ ucfirst($category->status) }}</flux:badge>
                            @endif
                        </td>
                        <td class="px-6 py-4 flex space-x-2">
                            @can('Category Edit')
                                <a href="{{ route('category.edit', $category->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">
                                    Edit
                                </a>
                            @endcan
                            @can('Category Delete')
                                <button onclick="confirmDelete({{ $category->id }})" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg">
                                    Delete
                                </button>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            {{ __('No categories found.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            $('#categoryTable').DataTable();
        });

        function confirmDelete(categoryId) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You are about to delete this category.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e3342f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('delete', categoryId);
                }
            });
        }

        window.addEventListener('categoryDeleted', event => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: event.detail.categoryName + ' deleted successfully',
                showConfirmButton: false,
                timer: 3000
            });
        });
    </script>
</div>
