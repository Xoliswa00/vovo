<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Services</h2>
            <a href="{{ route('services.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">+ New Service</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left">Service</th>
                            <th class="px-6 py-3 text-left">Category</th>
                            <th class="px-6 py-3 text-left">Vendor</th>
                            <th class="px-6 py-3 text-right">Price</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($services as $service)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">
                                <p class="font-medium">{{ $service->title }}</p>
                                <p class="text-gray-500 text-xs">{{ Str::limit($service->description, 60) }}</p>
                            </td>
                            <td class="px-6 py-3 text-gray-500">{{ $service->category->name ?? '—' }}</td>
                            <td class="px-6 py-3 text-gray-500">{{ $service->vendor->business_name ?? '—' }}</td>
                            <td class="px-6 py-3 text-right">{{ $service->price ? 'R '.number_format($service->price,2) : '—' }}</td>
                            <td class="px-6 py-3">
                                <span class="text-xs px-2 py-1 rounded-full {{ $service->status ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $service->status ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-3 flex gap-2">
                                <a href="{{ route('services.show', $service) }}" class="text-blue-600 hover:underline text-xs">View</a>
                                <a href="{{ route('services.edit', $service) }}" class="text-gray-600 hover:underline text-xs">Edit</a>
                                <button type="button" class="text-red-500 hover:underline text-xs"
                                    @click="$dispatch('open-confirm', { message: 'Delete service &quot;{{ addslashes($service->title) }}&quot;?', action: '{{ route('services.destroy', $service) }}' })">
                                    Del
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">No services yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $services->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
