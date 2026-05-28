<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Orders</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif

            {{-- Filters --}}
            <div class="mb-4 flex flex-wrap gap-2">
                @foreach(['', 'pending', 'confirmed', 'in_progress', 'completed', 'cancelled'] as $s)
                <a href="{{ route('orders.index', array_merge(request()->query(), $s ? ['status'=>$s] : ['status'=>null])) }}"
                   class="px-3 py-1 rounded-full text-sm {{ $status === $s || ($s==='' && !$status) ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    {{ $s ? ucfirst(str_replace('_',' ',$s)) : 'All' }}
                </a>
                @endforeach
                <span class="border-l mx-1"></span>
                @foreach(['', 'service', 'product', 'logistics'] as $t)
                <a href="{{ route('orders.index', array_merge(request()->query(), $t ? ['type'=>$t] : ['type'=>null])) }}"
                   class="px-3 py-1 rounded-full text-sm {{ $type === $t || ($t==='' && !$type) ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600' }}">
                    {{ $t ? ucfirst($t) : 'All Types' }}
                </a>
                @endforeach
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left">Order #</th>
                            <th class="px-6 py-3 text-left">Client</th>
                            <th class="px-6 py-3 text-left">Type</th>
                            <th class="px-6 py-3 text-right">Total</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Date</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 font-mono text-xs font-medium">{{ $order->order_number }}</td>
                            <td class="px-6 py-3">
                                <p class="font-medium">{{ $order->client_name }}</p>
                                <p class="text-gray-500 text-xs">{{ $order->client_email }}</p>
                            </td>
                            <td class="px-6 py-3 capitalize">{{ $order->type }}</td>
                            <td class="px-6 py-3 text-right font-medium">R {{ number_format($order->total, 2) }}</td>
                            <td class="px-6 py-3"><span class="text-xs px-2 py-1 rounded-full {{ $order->status_badge }}">{{ ucfirst(str_replace('_',' ',$order->status)) }}</span></td>
                            <td class="px-6 py-3 text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-3">
                                <a href="{{ route('orders.show', $order) }}" class="text-blue-600 hover:underline text-xs">View</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">No orders yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $orders->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
