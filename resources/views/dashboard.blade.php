<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {

        // ── Orders by Status (Donut) ─────────────────────────────
        new Chart(document.getElementById('ordersDonut'), {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Confirmed', 'In Progress', 'Completed', 'Cancelled'],
                datasets: [{
                    data: @json($chartData['ordersByStatus']),
                    backgroundColor: ['#fbbf24','#60a5fa','#818cf8','#34d399','#f87171'],
                    borderWidth: 0,
                    hoverOffset: 6,
                }]
            },
            options: {
                cutout: '70%',
                plugins: { legend: { position: 'bottom', labels: { padding: 16, font: { size: 12 } } } },
            }
        });

        // ── Shipments by Status (Bar) ────────────────────────────
        new Chart(document.getElementById('shipmentsBar'), {
            type: 'bar',
            data: {
                labels: ['Pending','Assigned','In Transit','Delivered','Cancelled'],
                datasets: [{
                    label: 'Shipments',
                    data: @json($chartData['shipmentsByStatus']),
                    backgroundColor: ['#fbbf2466','#60a5fa66','#818cf866','#34d39966','#f8717166'],
                    borderColor:     ['#fbbf24',  '#60a5fa',  '#818cf8',  '#34d399',  '#f87171'],
                    borderWidth: 2,
                    borderRadius: 6,
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f3f4f6' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // ── Orders over last 14 days (Line) ─────────────────────
        new Chart(document.getElementById('ordersLine'), {
            type: 'line',
            data: {
                labels: @json($chartData['dailyLabels']),
                datasets: [{
                    label: 'Orders',
                    data: @json($chartData['dailyCounts']),
                    borderColor: '#6366f1',
                    backgroundColor: '#6366f110',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#6366f1',
                }]
            },
            options: {
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: '#f3f4f6' } },
                    x: { grid: { display: false }, ticks: { maxRotation: 0, autoSkip: true, maxTicksLimit: 7 } }
                }
            }
        });

    });
    </script>
    @endpush

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ── Stat Cards ──────────────────────────────────────── --}}
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">

                @php
                $statCards = [
                    ['label' => 'Pending Orders',    'value' => $stats['pending_orders'],     'color' => 'yellow',  'icon' => 'receipt-cutoff', 'route' => route('orders.index', ['status'=>'pending'])],
                    ['label' => 'Active Shipments',  'value' => $stats['active_shipments'],   'color' => 'blue',    'icon' => 'truck', 'route' => route('shipments.index')],
                    ['label' => 'Pending Quotes',    'value' => $stats['pending_quotes'],     'color' => 'orange',  'icon' => 'clipboard-check', 'route' => route('quote-requests.index', ['status'=>'pending'])],
                    ['label' => 'Services',          'value' => $stats['total_services'],     'color' => 'indigo',  'icon' => 'gear', 'route' => route('services.index')],
                    ['label' => 'Products',          'value' => $stats['total_products'],     'color' => 'purple',  'icon' => 'cart3', 'route' => route('products.index')],
                    ['label' => 'Vehicles Ready',    'value' => $stats['available_vehicles'], 'color' => 'green',   'icon' => 'car-front', 'route' => route('vehicles.index')],
                ];
                $colorMap = [
                    'yellow' => 'bg-yellow-50 border-yellow-200 text-yellow-700',
                    'blue'   => 'bg-blue-50 border-blue-200 text-blue-700',
                    'orange' => 'bg-orange-50 border-orange-200 text-orange-700',
                    'indigo' => 'bg-indigo-50 border-indigo-200 text-indigo-700',
                    'purple' => 'bg-purple-50 border-purple-200 text-purple-700',
                    'green'  => 'bg-green-50 border-green-200 text-green-700',
                ];
                @endphp

                @foreach($statCards as $card)
                <a href="{{ $card['route'] }}"
                   class="group border rounded-xl p-4 text-center hover:shadow-lg transition-all duration-200 hover:-translate-y-0.5 {{ $colorMap[$card['color']] }}">
                    <div class="text-2xl mb-1"><i class="bi bi-{{ $card['icon'] }}"></i></div>
                    <div class="text-3xl font-extrabold">{{ $card['value'] }}</div>
                    <div class="text-xs font-medium mt-1 opacity-80">{{ $card['label'] }}</div>
                </a>
                @endforeach
            </div>

            {{-- ── Charts Row ────────────────────────────────────── --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Orders Donut --}}
                <div class="bg-white shadow rounded-2xl p-5">
                    <h3 class="font-semibold text-gray-700 mb-4 text-sm uppercase tracking-wide">Orders by Status</h3>
                    <div class="relative" style="height:220px">
                        <canvas id="ordersDonut"></canvas>
                    </div>
                </div>

                {{-- Orders Line (spans 2 cols) --}}
                <div class="lg:col-span-2 bg-white shadow rounded-2xl p-5">
                    <h3 class="font-semibold text-gray-700 mb-4 text-sm uppercase tracking-wide">Orders — Last 14 Days</h3>
                    <div style="height:220px">
                        <canvas id="ordersLine"></canvas>
                    </div>
                </div>
            </div>

            {{-- Shipments Bar --}}
            <div class="bg-white shadow rounded-2xl p-5">
                <h3 class="font-semibold text-gray-700 mb-4 text-sm uppercase tracking-wide">Shipments by Status</h3>
                <div style="height:200px">
                    <canvas id="shipmentsBar"></canvas>
                </div>
            </div>

            {{-- ── Recent Activity ───────────────────────────────── --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Recent Orders --}}
                <div class="bg-white shadow rounded-2xl overflow-hidden">
                    <div class="flex justify-between items-center px-6 py-4 border-b">
                        <h3 class="font-semibold text-gray-800">Recent Orders</h3>
                        <a href="{{ route('orders.index') }}" class="text-xs text-indigo-600 hover:underline font-medium">View all →</a>
                    </div>
                    <div class="divide-y">
                        @forelse($recentOrders as $order)
                        <a href="{{ route('orders.show', $order) }}" class="flex justify-between items-center px-6 py-3 hover:bg-gray-50 transition">
                            <div>
                                <p class="text-sm font-semibold text-gray-800 font-mono">{{ $order->order_number }}</p>
                                <p class="text-xs text-gray-500">{{ $order->client_name }} &middot; {{ ucfirst($order->type) }}</p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full font-medium {{ $order->status_badge }}">{{ ucfirst(str_replace('_',' ',$order->status)) }}</span>
                        </a>
                        @empty
                        <div class="px-6 py-10 text-center">
                            <p class="text-3xl mb-2 text-gray-300"><i class="bi bi-inbox"></i></p>
                            <p class="text-sm text-gray-400">No orders yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                {{-- Recent Shipments --}}
                <div class="bg-white shadow rounded-2xl overflow-hidden">
                    <div class="flex justify-between items-center px-6 py-4 border-b">
                        <h3 class="font-semibold text-gray-800">Recent Shipments</h3>
                        <a href="{{ route('shipments.index') }}" class="text-xs text-indigo-600 hover:underline font-medium">View all →</a>
                    </div>
                    <div class="divide-y">
                        @forelse($recentShipments as $shipment)
                        <a href="{{ route('shipments.show', $shipment) }}" class="flex justify-between items-center px-6 py-3 hover:bg-gray-50 transition">
                            <div>
                                <p class="text-sm font-semibold text-gray-800">{{ $shipment->origin }} → {{ $shipment->destination }}</p>
                                <p class="text-xs text-gray-500">{{ $shipment->vehicle->name ?? 'Unassigned' }} &middot; {{ $shipment->driver_name ?? 'No driver' }}</p>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full font-medium {{ $shipment->status_badge }}">{{ ucfirst(str_replace('_',' ',$shipment->status)) }}</span>
                        </a>
                        @empty
                        <div class="px-6 py-10 text-center">
                            <p class="text-3xl mb-2 text-gray-300"><i class="bi bi-truck"></i></p>
                            <p class="text-sm text-gray-400">No shipments yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- ── Quick Actions ─────────────────────────────────── --}}
            <div class="bg-white shadow rounded-2xl p-6">
                <h3 class="font-semibold text-gray-800 mb-4 text-sm uppercase tracking-wide">Quick Actions</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('vehicles.create') }}"       class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition shadow-sm">+ Add Vehicle</a>
                    <a href="{{ route('shipments.create') }}"      class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition shadow-sm">+ New Shipment</a>
                    <a href="{{ route('services.create') }}"       class="px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition shadow-sm">+ Add Service</a>
                    <a href="{{ route('products.create') }}"       class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-medium hover:bg-purple-700 transition shadow-sm">+ Add Product</a>
                    <a href="{{ route('quote-requests.index') }}"  class="px-4 py-2 bg-orange-500 text-white rounded-lg text-sm font-medium hover:bg-orange-600 transition shadow-sm">Review Quotes</a>
                    <a href="{{ route('categories.create') }}"     class="px-4 py-2 bg-gray-600 text-white rounded-lg text-sm font-medium hover:bg-gray-700 transition shadow-sm">+ Category</a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
