<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Vendors</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 flex justify-end">
                <a href="{{ route('vendors.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">+ Add Vendor</a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left">Business</th>
                            <th class="px-6 py-3 text-left">Phone</th>
                            <th class="px-6 py-3 text-left">Services</th>
                            <th class="px-6 py-3 text-left">Products</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($vendors as $vendor)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">
                                <p class="font-medium">{{ $vendor->business_name }}</p>
                                <p class="text-gray-500 text-xs">{{ $vendor->address ?? '' }}</p>
                            </td>
                            <td class="px-6 py-3">{{ $vendor->phone ?? '—' }}</td>
                            <td class="px-6 py-3">{{ $vendor->services_count }}</td>
                            <td class="px-6 py-3">{{ $vendor->products_count }}</td>
                            <td class="px-6 py-3">
                                <span class="text-xs px-2 py-1 rounded-full {{ $vendor->status === 'active' ? 'bg-green-100 text-green-800' : ($vendor->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-600') }}">
                                    {{ ucfirst($vendor->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-3 flex gap-2">
                                <a href="{{ route('vendors.show', $vendor) }}" class="text-blue-600 hover:underline text-xs">View</a>
                                <a href="{{ route('vendors.edit', $vendor) }}" class="text-gray-600 hover:underline text-xs">Edit</a>
                                <button type="button" class="text-red-500 hover:underline text-xs"
                                    @click="$dispatch('open-confirm', { message: 'Delete vendor &quot;{{ addslashes($vendor->business_name) }}&quot;?', action: '{{ route('vendors.destroy', $vendor) }}' })">
                                    Del
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">No vendors yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $vendors->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
