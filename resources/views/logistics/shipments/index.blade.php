<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Shipments</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 flex justify-end">
                <a href="{{ route('shipments.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">+ New Shipment</a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left">Route</th>
                            <th class="px-6 py-3 text-left">Vehicle</th>
                            <th class="px-6 py-3 text-left">Driver</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Pickup</th>
                            <th class="px-6 py-3 text-left">Delivery</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($shipments as $shipment)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">
                                <a href="{{ route('shipments.show', $shipment) }}" class="font-medium text-blue-600 hover:underline">{{ $shipment->origin }}</a>
                                <span class="text-gray-400"> → </span>{{ $shipment->destination }}
                            </td>
                            <td class="px-6 py-3">{{ $shipment->vehicle->name ?? '—' }}</td>
                            <td class="px-6 py-3">{{ $shipment->driver_name ?? '—' }}</td>
                            <td class="px-6 py-3"><span class="text-xs px-2 py-1 rounded-full {{ $shipment->status_badge }}">{{ ucfirst(str_replace('_',' ',$shipment->status)) }}</span></td>
                            <td class="px-6 py-3">{{ $shipment->pickup_date?->format('d M Y') ?? '—' }}</td>
                            <td class="px-6 py-3">{{ $shipment->delivery_date?->format('d M Y') ?? '—' }}</td>
                            <td class="px-6 py-3">
                                <a href="{{ route('shipments.edit', $shipment) }}" class="text-gray-600 hover:text-blue-600 mr-2">Edit</a>
                                <button type="button" class="text-red-500 hover:text-red-700"
                                    @click="$dispatch('open-confirm', { message: 'Delete this shipment? This cannot be undone.', action: '{{ route('shipments.destroy', $shipment) }}' })">
                                    Del
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">No shipments yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $shipments->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
