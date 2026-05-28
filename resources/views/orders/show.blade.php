<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Order {{ $order->order_number }}</h2>
            <a href="{{ route('orders.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm">Back</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Order Info --}}
                <div class="md:col-span-2 bg-white shadow rounded-lg p-6 space-y-4">
                    <div class="flex justify-between items-center">
                        <h3 class="font-semibold text-gray-800">Order Details</h3>
                        <span class="px-3 py-1 rounded-full text-sm {{ $order->status_badge }}">{{ ucfirst(str_replace('_',' ',$order->status)) }}</span>
                    </div>
                    <div class="grid grid-cols-2 gap-3 text-sm">
                        <div><p class="text-gray-500 text-xs">Client</p><p class="font-medium">{{ $order->client_name }}</p></div>
                        <div><p class="text-gray-500 text-xs">Email</p><p class="font-medium">{{ $order->client_email }}</p></div>
                        <div><p class="text-gray-500 text-xs">Phone</p><p class="font-medium">{{ $order->client_phone ?? '—' }}</p></div>
                        <div><p class="text-gray-500 text-xs">Type</p><p class="font-medium capitalize">{{ $order->type }}</p></div>
                        <div><p class="text-gray-500 text-xs">Date</p><p class="font-medium">{{ $order->created_at->format('d M Y H:i') }}</p></div>
                        <div><p class="text-gray-500 text-xs">Total</p><p class="font-bold text-lg">R {{ number_format($order->total, 2) }}</p></div>
                    </div>
                    @if($order->notes)<div class="text-sm border-t pt-3"><p class="text-gray-500 text-xs">Notes</p><p>{{ $order->notes }}</p></div>@endif

                    {{-- Order Items --}}
                    @if($order->items->count())
                    <div class="border-t pt-4">
                        <h4 class="font-semibold text-sm text-gray-700 mb-2">Items</h4>
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 text-xs text-gray-500">
                                <tr><th class="px-3 py-2 text-left">Item</th><th class="px-3 py-2 text-right">Qty</th><th class="px-3 py-2 text-right">Unit Price</th><th class="px-3 py-2 text-right">Subtotal</th></tr>
                            </thead>
                            <tbody class="divide-y">
                                @foreach($order->items as $item)
                                <tr>
                                    <td class="px-3 py-2">{{ $item->orderable?->title ?? class_basename($item->orderable_type) . ' #' . $item->orderable_id }}</td>
                                    <td class="px-3 py-2 text-right">{{ $item->quantity }}</td>
                                    <td class="px-3 py-2 text-right">R {{ number_format($item->unit_price, 2) }}</td>
                                    <td class="px-3 py-2 text-right font-medium">R {{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>

                {{-- Update Status + Shipment --}}
                <div class="space-y-4">
                    <div class="bg-white shadow rounded-lg p-4">
                        <h4 class="font-semibold text-sm text-gray-700 mb-3">Update Status</h4>
                        <form method="POST" action="{{ route('orders.update', $order) }}">
                            @csrf @method('PATCH')
                            <select name="status" class="w-full border-gray-300 rounded-md shadow-sm text-sm mb-3">
                                @foreach(['pending','confirmed','in_progress','completed','cancelled'] as $s)
                                    <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                                @endforeach
                            </select>
                            <textarea name="notes" rows="3" class="w-full border-gray-300 rounded-md shadow-sm text-sm mb-3" placeholder="Notes...">{{ $order->notes }}</textarea>
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">Update</button>
                        </form>
                    </div>

                    @if($order->shipment)
                    <div class="bg-white shadow rounded-lg p-4">
                        <h4 class="font-semibold text-sm text-gray-700 mb-2">Shipment</h4>
                        <p class="text-sm">{{ $order->shipment->origin }} → {{ $order->shipment->destination }}</p>
                        <span class="text-xs px-2 py-1 rounded-full {{ $order->shipment->status_badge }}">{{ ucfirst(str_replace('_',' ',$order->shipment->status)) }}</span>
                        <a href="{{ route('shipments.show', $order->shipment) }}" class="block text-sm text-blue-600 hover:underline mt-2">View Shipment</a>
                    </div>
                    @else
                    <div class="bg-white shadow rounded-lg p-4">
                        <h4 class="font-semibold text-sm text-gray-700 mb-2">No Shipment</h4>
                        <a href="{{ route('shipments.create', ['order_id' => $order->id]) }}" class="text-sm text-blue-600 hover:underline">Create Shipment</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
