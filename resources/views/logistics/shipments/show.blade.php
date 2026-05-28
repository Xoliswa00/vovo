<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800">Shipment Detail</h2>
                <p class="text-sm text-gray-500 mt-0.5">{{ $shipment->origin }} → {{ $shipment->destination }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('shipments.edit', $shipment) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">Edit</a>
                <a href="{{ route('shipments.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:bg-gray-300 transition">Back</a>
            </div>
        </div>
    </x-slot>

    @push('styles')
    <style>
        .timeline-step { position: relative; }
        .timeline-step:not(:last-child)::after {
            content: '';
            position: absolute;
            left: 19px;
            top: 40px;
            bottom: -12px;
            width: 2px;
            background: #e5e7eb;
        }
        .timeline-step.active::after  { background: #6366f1; }
        .timeline-step.done::after    { background: #34d399; }
    </style>
    @endpush

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm">{{ session('success') }}</div>
            @endif

            @php
                $steps = [
                    ['key' => 'pending',    'label' => 'Created',    'icon' => '📋', 'desc' => 'Shipment request received'],
                    ['key' => 'assigned',   'label' => 'Assigned',   'icon' => '🚛', 'desc' => 'Vehicle and driver assigned'],
                    ['key' => 'in_transit', 'label' => 'In Transit', 'icon' => '📍', 'desc' => 'On the road'],
                    ['key' => 'delivered',  'label' => 'Delivered',  'icon' => '✅', 'desc' => 'Successfully delivered'],
                ];
                $statusOrder  = ['pending' => 0, 'assigned' => 1, 'in_transit' => 2, 'delivered' => 3, 'cancelled' => -1];
                $currentIndex = $statusOrder[$shipment->status] ?? 0;
                $cancelled    = $shipment->status === 'cancelled';
            @endphp

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- LEFT: Timeline + Details --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Status Timeline --}}
                    <div class="bg-white shadow rounded-2xl p-6">
                        <h3 class="font-semibold text-gray-800 mb-5">Shipment Progress</h3>

                        @if($cancelled)
                        <div class="flex items-center gap-3 p-4 bg-red-50 border border-red-200 rounded-xl">
                            <span class="text-2xl">❌</span>
                            <div>
                                <p class="font-semibold text-red-800">Shipment Cancelled</p>
                                <p class="text-sm text-red-600">This shipment has been cancelled.</p>
                            </div>
                        </div>
                        @else
                        <div class="space-y-3 pl-2">
                            @foreach($steps as $i => $step)
                            @php
                                $isDone   = $i < $currentIndex;
                                $isActive = $i === $currentIndex;
                                $isPending = $i > $currentIndex;
                            @endphp
                            <div class="timeline-step {{ $isDone ? 'done' : ($isActive ? 'active' : '') }} flex items-start gap-4 pb-6">

                                {{-- Circle indicator --}}
                                <div class="shrink-0 w-10 h-10 rounded-full flex items-center justify-center text-lg border-2 z-10
                                    {{ $isDone   ? 'bg-green-500 border-green-500 text-white' : '' }}
                                    {{ $isActive ? 'bg-indigo-600 border-indigo-600 text-white ring-4 ring-indigo-100' : '' }}
                                    {{ $isPending ? 'bg-white border-gray-200 text-gray-300' : '' }}">
                                    @if($isDone)
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                    @else
                                        {{ $step['icon'] }}
                                    @endif
                                </div>

                                {{-- Content --}}
                                <div class="flex-1 pt-1.5">
                                    <p class="font-semibold text-sm
                                        {{ $isDone   ? 'text-green-700' : '' }}
                                        {{ $isActive ? 'text-indigo-700' : '' }}
                                        {{ $isPending ? 'text-gray-400' : '' }}">
                                        {{ $step['label'] }}
                                        @if($isActive) <span class="ml-2 text-xs bg-indigo-100 text-indigo-700 px-2 py-0.5 rounded-full">Current</span> @endif
                                    </p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ $step['desc'] }}</p>

                                    {{-- Show dates when available --}}
                                    @if($step['key'] === 'assigned' && $shipment->vehicle)
                                        <p class="text-xs text-gray-600 mt-1">🚛 {{ $shipment->vehicle->name }} &middot; {{ $shipment->driver_name ?? 'Driver TBD' }}</p>
                                    @endif
                                    @if($step['key'] === 'in_transit' && $shipment->pickup_date)
                                        <p class="text-xs text-gray-600 mt-1">📅 Pickup: {{ $shipment->pickup_date->format('d M Y') }}</p>
                                    @endif
                                    @if($step['key'] === 'delivered' && $shipment->delivery_date)
                                        <p class="text-xs text-gray-600 mt-1">📅 Delivered: {{ $shipment->delivery_date->format('d M Y') }}</p>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>

                    {{-- Route & Cargo Details --}}
                    <div class="bg-white shadow rounded-2xl p-6">
                        <h3 class="font-semibold text-gray-800 mb-4">Shipment Details</h3>
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <p class="text-xs text-gray-500 mb-1">Origin</p>
                                <p class="font-semibold text-gray-900">{{ $shipment->origin }}</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <p class="text-xs text-gray-500 mb-1">Destination</p>
                                <p class="font-semibold text-gray-900">{{ $shipment->destination }}</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <p class="text-xs text-gray-500 mb-1">Pickup Date</p>
                                <p class="font-semibold text-gray-900">{{ $shipment->pickup_date?->format('d M Y') ?? '—' }}</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <p class="text-xs text-gray-500 mb-1">Delivery Date</p>
                                <p class="font-semibold text-gray-900">{{ $shipment->delivery_date?->format('d M Y') ?? '—' }}</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <p class="text-xs text-gray-500 mb-1">Weight</p>
                                <p class="font-semibold text-gray-900">{{ $shipment->weight_kg ? number_format($shipment->weight_kg).' kg' : '—' }}</p>
                            </div>
                            <div class="p-3 bg-gray-50 rounded-xl">
                                <p class="text-xs text-gray-500 mb-1">Driver</p>
                                <p class="font-semibold text-gray-900">{{ $shipment->driver_name ?? '—' }}</p>
                                @if($shipment->driver_phone)<p class="text-xs text-gray-500">{{ $shipment->driver_phone }}</p>@endif
                            </div>
                        </div>

                        @if($shipment->cargo_description)
                        <div class="mt-4 p-3 bg-gray-50 rounded-xl text-sm">
                            <p class="text-xs text-gray-500 mb-1">Cargo Description</p>
                            <p class="text-gray-800">{{ $shipment->cargo_description }}</p>
                        </div>
                        @endif
                    </div>

                    {{-- Tracking Notes --}}
                    @if($shipment->tracking_notes)
                    <div class="bg-white shadow rounded-2xl p-6">
                        <h3 class="font-semibold text-gray-800 mb-3">Tracking Notes</h3>
                        <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-4 text-sm text-gray-700 whitespace-pre-line">{{ $shipment->tracking_notes }}</div>
                    </div>
                    @endif
                </div>

                {{-- RIGHT: Side Cards --}}
                <div class="space-y-4">

                    {{-- Assigned Vehicle --}}
                    @if($shipment->vehicle)
                    <div class="bg-white shadow rounded-2xl p-5">
                        <h4 class="font-semibold text-sm text-gray-600 uppercase tracking-wide mb-3">Vehicle</h4>
                        <div class="text-2xl mb-2">🚛</div>
                        <p class="font-bold text-gray-900">{{ $shipment->vehicle->name }}</p>
                        <p class="text-sm text-gray-500">{{ $shipment->vehicle->registration_plate }}</p>
                        <p class="text-sm text-gray-500">{{ ucfirst($shipment->vehicle->type) }}{{ $shipment->vehicle->make ? ' · '.$shipment->vehicle->make : '' }}</p>
                        <span class="inline-block mt-2 text-xs px-2 py-1 rounded-full {{ $shipment->vehicle->status_badge }}">{{ ucfirst(str_replace('_',' ',$shipment->vehicle->status)) }}</span>
                        <div class="mt-3 pt-3 border-t">
                            <a href="{{ route('vehicles.show', $shipment->vehicle) }}" class="text-sm text-indigo-600 hover:underline font-medium">View Vehicle →</a>
                        </div>
                    </div>
                    @else
                    <div class="bg-white shadow rounded-2xl p-5 text-center">
                        <p class="text-3xl mb-2">🚛</p>
                        <p class="text-sm text-gray-500 mb-3">No vehicle assigned</p>
                        <a href="{{ route('shipments.edit', $shipment) }}" class="text-sm text-indigo-600 hover:underline font-medium">Assign vehicle →</a>
                    </div>
                    @endif

                    {{-- Linked Order --}}
                    @if($shipment->order)
                    <div class="bg-white shadow rounded-2xl p-5">
                        <h4 class="font-semibold text-sm text-gray-600 uppercase tracking-wide mb-3">Linked Order</h4>
                        <p class="font-bold font-mono text-gray-900">{{ $shipment->order->order_number }}</p>
                        <p class="text-sm text-gray-500">{{ $shipment->order->client_name }}</p>
                        <p class="text-sm text-gray-500">{{ $shipment->order->client_email }}</p>
                        <div class="mt-3 pt-3 border-t">
                            <a href="{{ route('orders.show', $shipment->order) }}" class="text-sm text-indigo-600 hover:underline font-medium">View Order →</a>
                        </div>
                    </div>
                    @endif

                    {{-- Quick Update Status --}}
                    <div class="bg-white shadow rounded-2xl p-5">
                        <h4 class="font-semibold text-sm text-gray-600 uppercase tracking-wide mb-3">Quick Status Update</h4>
                        <form method="POST" action="{{ route('shipments.update', $shipment) }}">
                            @csrf @method('PATCH')
                            <input type="hidden" name="origin" value="{{ $shipment->origin }}">
                            <input type="hidden" name="destination" value="{{ $shipment->destination }}">
                            <input type="hidden" name="status" id="quickStatus" value="{{ $shipment->status }}">
                            <div class="grid grid-cols-1 gap-2">
                                @foreach(['pending','assigned','in_transit','delivered','cancelled'] as $s)
                                <button type="submit"
                                    onclick="document.getElementById('quickStatus').value='{{ $s }}'"
                                    class="w-full text-left px-3 py-2 rounded-lg text-sm font-medium transition border
                                        {{ $shipment->status === $s
                                            ? 'bg-indigo-600 text-white border-indigo-600'
                                            : 'bg-white text-gray-700 border-gray-200 hover:border-indigo-300 hover:bg-indigo-50' }}">
                                    {{ ucfirst(str_replace('_',' ',$s)) }}
                                </button>
                                @endforeach
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
