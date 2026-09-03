<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Products</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 flex justify-end">
                <a href="{{ route('products.create') }}" class="px-4 py-2 bg-purple-600 text-white rounded-md text-sm hover:bg-purple-700">+ Add Product</a>
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[720px]">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left">Product</th>
                            <th class="px-6 py-3 text-left">Category</th>
                            <th class="px-6 py-3 text-left">Vendor</th>
                            <th class="px-6 py-3 text-right">Price</th>
                            <th class="px-6 py-3 text-right">Stock</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 font-medium">{{ $product->title }}</td>
                            <td class="px-6 py-3 text-gray-500">{{ $product->category->name ?? '—' }}</td>
                            <td class="px-6 py-3 text-gray-500">{{ $product->vendor->business_name ?? '—' }}</td>
                            <td class="px-6 py-3 text-right font-medium">R {{ number_format($product->price, 2) }}</td>
                            <td class="px-6 py-3 text-right {{ $product->stock <= 0 ? 'text-red-500' : '' }}">{{ $product->stock }}</td>
                            <td class="px-6 py-3">
                                <span class="text-xs px-2 py-1 rounded-full {{ $product->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 flex gap-2">
                                <a href="{{ route('marketplace.show', $product) }}" class="text-blue-600 hover:underline text-xs">View</a>
                                <a href="{{ route('products.edit', $product) }}" class="text-gray-600 hover:underline text-xs">Edit</a>
                                <button type="button" class="text-red-500 hover:underline text-xs"
                                    @click="$dispatch('open-confirm', { message: 'Delete product &quot;{{ addslashes($product->title) }}&quot;?', action: '{{ route('products.destroy', $product) }}' })">
                                    Del
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">No products yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
                <div class="p-4">{{ $products->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
