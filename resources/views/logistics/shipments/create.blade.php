<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ isset($shipment) ? 'Edit Shipment' : 'New Shipment' }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ isset($shipment) ? route('shipments.update', $shipment) : route('shipments.store') }}">
                    @csrf
                    @if(isset($shipment)) @method('PATCH') @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Linked Order</label>
                            <select name="order_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">— None —</option>
                                @foreach($orders as $order)
                                    <option value="{{ $order->id }}" {{ old('order_id', $shipment->order_id ?? '') == $order->id ? 'selected' : '' }}>
                                        {{ $order->order_number }} — {{ $order->client_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Assign Vehicle</label>
                            <select name="vehicle_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">— Unassigned —</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $shipment->vehicle_id ?? '') == $vehicle->id ? 'selected' : '' }}>
                                        {{ $vehicle->name }} ({{ $vehicle->registration_plate }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status *</label>
                            <select name="status" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @foreach(['pending','assigned','in_transit','delivered','cancelled'] as $s)
                                    <option value="{{ $s }}" {{ old('status', $shipment->status ?? 'pending') === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Origin *</label>
                            <input type="text" name="origin" value="{{ old('origin', $shipment->origin ?? '') }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            @error('origin')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Destination *</label>
                            <input type="text" name="destination" value="{{ old('destination', $shipment->destination ?? '') }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            @error('destination')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Driver Name</label>
                            <input type="text" name="driver_name" value="{{ old('driver_name', $shipment->driver_name ?? '') }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Driver Phone</label>
                            <input type="text" name="driver_phone" value="{{ old('driver_phone', $shipment->driver_phone ?? '') }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Weight (kg)</label>
                            <input type="number" name="weight_kg" value="{{ old('weight_kg', $shipment->weight_kg ?? '') }}" min="0" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pickup Date</label>
                            <input type="date" name="pickup_date" value="{{ old('pickup_date', isset($shipment) ? $shipment->pickup_date?->format('Y-m-d') : '') }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Delivery Date</label>
                            <input type="date" name="delivery_date" value="{{ old('delivery_date', isset($shipment) ? $shipment->delivery_date?->format('Y-m-d') : '') }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Cargo Description</label>
                            <textarea name="cargo_description" rows="2" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('cargo_description', $shipment->cargo_description ?? '') }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Tracking Notes</label>
                            <textarea name="tracking_notes" rows="3" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="Update notes as the shipment progresses...">{{ old('tracking_notes', $shipment->tracking_notes ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ isset($shipment) ? 'Update Shipment' : 'Create Shipment' }}
                        </button>
                        <a href="{{ route('shipments.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
