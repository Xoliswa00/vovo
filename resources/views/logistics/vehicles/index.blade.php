<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Fleet Management</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 flex justify-end">
                <a href="{{ route('vehicles.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">+ Add Vehicle</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($vehicles as $vehicle)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <div class="p-5">
                        <div class="flex justify-between items-start mb-3">
                            <div>
                                <h3 class="font-bold text-gray-900 text-lg">{{ $vehicle->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $vehicle->registration_plate }}</p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full {{ $vehicle->status_badge }}">{{ ucfirst(str_replace('_',' ',$vehicle->status)) }}</span>
                        </div>
                        <div class="text-sm text-gray-600 space-y-1">
                            <p><i class="bi bi-truck me-1"></i> {{ ucfirst($vehicle->type) }}{{ $vehicle->make ? ' — ' . $vehicle->make . ' ' . $vehicle->model : '' }}</p>
                            @if($vehicle->capacity_kg)<p><i class="bi bi-box me-1"></i> {{ number_format($vehicle->capacity_kg) }} kg capacity</p>@endif
                            @if($vehicle->year)<p><i class="bi bi-calendar me-1"></i> {{ $vehicle->year }}</p>@endif
                        </div>
                        <div class="mt-4 flex gap-2">
                            <a href="{{ route('vehicles.show', $vehicle) }}" class="text-sm text-blue-600 hover:underline">View</a>
                            <a href="{{ route('vehicles.edit', $vehicle) }}" class="text-sm text-gray-600 hover:underline">Edit</a>
                            <button type="button"
                                class="text-sm text-red-600 hover:underline"
                                @click="$dispatch('open-confirm', { message: 'Delete {{ addslashes($vehicle->name) }}? This cannot be undone.', action: '{{ route('vehicles.destroy', $vehicle) }}' })">
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-16 text-gray-400">
                    <div class="text-6xl mb-4 opacity-30">🚛</div>
                    <p class="text-lg font-semibold text-gray-500 mb-1">No vehicles yet</p>
                    <p class="text-sm mb-4">Add your first vehicle to start managing your fleet.</p>
                    <a href="{{ route('vehicles.create') }}" class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition">+ Add Vehicle</a>
                </div>
                @endforelse
            </div>

            <div class="mt-6">{{ $vehicles->links() }}</div>
        </div>
    </div>
</x-app-layout>
