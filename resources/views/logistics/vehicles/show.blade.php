<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ $vehicle->name }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow rounded-lg px-4 py-3 flex flex-wrap items-center justify-between gap-3">
                <a href="{{ route('vehicles.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">&larr; Back to Fleet</a>
                <a href="{{ route('vehicles.edit', $vehicle) }}" class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">Edit</a>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div><p class="text-xs text-gray-500">Plate</p><p class="font-semibold">{{ $vehicle->registration_plate }}</p></div>
                    <div><p class="text-xs text-gray-500">Type</p><p class="font-semibold">{{ ucfirst($vehicle->type) }}</p></div>
                    <div><p class="text-xs text-gray-500">Make/Model</p><p class="font-semibold">{{ $vehicle->make ?? '—' }} {{ $vehicle->model ?? '' }}</p></div>
                    <div><p class="text-xs text-gray-500">Year</p><p class="font-semibold">{{ $vehicle->year ?? '—' }}</p></div>
                    <div><p class="text-xs text-gray-500">Capacity</p><p class="font-semibold">{{ $vehicle->capacity_kg ? number_format($vehicle->capacity_kg) . ' kg' : '—' }}</p></div>
                    <div><p class="text-xs text-gray-500">Status</p><span class="text-sm px-2 py-1 rounded-full {{ $vehicle->status_badge }}">{{ ucfirst(str_replace('_',' ',$vehicle->status)) }}</span></div>
                </div>
                @if($vehicle->notes)<div class="mt-4 text-sm text-gray-600"><strong>Notes:</strong> {{ $vehicle->notes }}</div>@endif
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b font-semibold text-gray-800">Shipment History</div>
                <div class="overflow-x-auto">
                <table class="w-full text-sm min-w-[560px]">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left">Route</th>
                            <th class="px-6 py-3 text-left">Driver</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($vehicle->shipments as $shipment)
                        <tr>
                            <td class="px-6 py-3"><a href="{{ route('shipments.show', $shipment) }}" class="text-blue-600 hover:underline">{{ $shipment->origin }} → {{ $shipment->destination }}</a></td>
                            <td class="px-6 py-3">{{ $shipment->driver_name ?? '—' }}</td>
                            <td class="px-6 py-3"><span class="text-xs px-2 py-1 rounded-full {{ $shipment->status_badge }}">{{ ucfirst(str_replace('_',' ',$shipment->status)) }}</span></td>
                            <td class="px-6 py-3">{{ $shipment->pickup_date?->format('d M Y') ?? '—' }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="px-6 py-6 text-center text-gray-400">No shipments recorded.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
