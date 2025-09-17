<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Products') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage all your products') }}</flux:subheading>
         @can('Product Add')
        <flux:button variant="primary" href="{{ route('products.create') }}">Create Products</flux:button>
        @endcan        
    </div>
    <div class="overflow-x-auto mt-6">
        <table id="myCustomTable" class="text-black">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Details</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="odd:bg-white">
                        <td class="px-6 text-black">{{ $product->id }}</td>
                        <td class="px-6 text-black">{{ $product->name }}</td>
                        <td class="px-6 text-black">{{ $product->detail }}</td>
                        <td class="px-6 py-2 flex space-x-2">
                        @can('Product Show')<a href="{{ route('products.show', $product->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg mr-2">Show</a>@endcan
                        @can('Product Edit')<a href="{{ route('products.edit', $product->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg mr-2">Edit</a>@endcan
                        @can('Product Delete')<button onclick="confirmDelete({{ $product->id }})" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg">Delete</button>@endcan 
                        </form>
                        </td>
                    </tr>
                @endforeach

                @if ($products->isEmpty())
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            No products found.
                        </td>
                    </tr>
                @endif
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
                { data: 'detail', name: 'detail' },
                { data: 'action', name: 'action', orderable: true, searchable: true }
            ]
        });
    });
    function confirmDelete(productId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You are about to delete ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                @this.call('delete', productId);
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

