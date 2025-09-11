<div>
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('Products') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('Manage all your products') }}</flux:subheading>
        <flux:separator variant="subtle" />
    </div>
    @if (session('success'))
        <div class="mb-4 rounded-md bg-green-100 border border-green-400 text-green-700 px-4 py-3" style="background: #00a63e;" color="green">
            {{ session('success') }}
        </div>
    @endif
    @can('product.create')
    <flux:button variant="primary" href="{{ route('products.create') }}">Create Products</flux:button>
    @endcan
    <div class="overflow-x-auto mt-6">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">ID</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Details</th>
                    <th scope="col" class="px-6 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800">
                        <td class="px-6 py-2 text-gray-900 dark:text-white">{{ $product->id }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $product->name }}</td>
                        <td class="px-6 py-2 text-gray-600 dark:text-gray-300">{{ $product->detail }}</td>
                        <td class="px-6 py-2 flex space-x-2">
                       @can('product.show')<a href="{{ route('products.show', $product->id) }}" class="bg-green-500 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg mr-2">Show</a>@endcan
                        @can('product.edit')<a href="{{ route('products.edit', $product->id) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg mr-2">Edit</a>@endcan
                        @can('product.delete')<button wire:click="delete({{ $product->id }})" type="submit" wire:confirm="Are you sure to remove this user?" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-4 rounded-lg">Delete</button>@endcan
                            
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
