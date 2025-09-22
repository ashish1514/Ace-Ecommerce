<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Products') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage all your products') }}</flux:subheading>
        
        @can('Product Add')
            <flux:button variant="primary" href="{{ route('products.create') }}">
                {{ __('Create Products') }}
            </flux:button>
        @endcan
    </div>

    <div class="overflow-x-auto mt-6">
        <table id="myCustomTable" class="w-full text-black">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Details</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="odd:bg-white even:bg-gray-50">
                        <td class="px-6 py-4 text-black">{{ $product->name }}</td>
                        <td class="px-6 py-4 text-black">{{ $product->detail }}</td>
                        <td class="px-6 py-2 text-black">
                            @if($product->status === 'Active')
                                <flux:badge class="bg-green-500 text-white" color="green">{{ ucfirst($product->status) }}</flux:badge>
                            @else
                                <flux:badge class="bg-red-500 text-white" color="red">{{ ucfirst($product->status) }}</flux:badge>
                            @endif
                        </td>                        <td class="px-6 py-4 flex space-x-2">
                            @can('Product Edit')
                                <a href="{{ route('products.edit', $product->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">
                                    Edit
                                </a>
                            @endcan

                            @can('Product Delete')
                                <button onclick="confirmDelete({{ $product->id }}, '{{ $product->name }}')" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg">
                                    Delete
                                </button>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            {{ __('No products found.') }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#myCustomTable').DataTable({
        });
    });

    function confirmDelete(productId, productName) {
        Swal.fire({
            title: 'Are you sure?',
            text: `You are about to delete "${productName}". This action cannot be undone.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Livewire.emit('delete', productId);
            }
        });
    }

    document.addEventListener('livewire:productDeleted', (event) => {
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: `${event.detail.productName} deleted successfully`,
            showConfirmButton: false,
            timer: 3000
        });
    });
</script>
