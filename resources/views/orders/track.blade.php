@extends('layouts.public')

@section('title', 'Track Order ' . $order->order_number . ' — Nobela Enterprises')

@section('content')
<section class="py-16">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold font-heading text-navy">Order Tracking</h2>
            <p class="text-muted">Order #<strong class="text-navy">{{ $order->order_number }}</strong></p>
        </div>

        @if(session('success'))
            <div class="alert-success-brand mb-4">{{ session('success') }}</div>
        @endif

        <div class="card-brand p-6 mb-4">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h5 class="font-bold text-navy mb-0">{{ $order->client_name }}</h5>
                    <small class="text-muted">{{ $order->client_email }}</small>
                </div>
                <span @class([
                    'badge-brand text-sm',
                    'bg-amber-100 text-amber-800' => $order->status === 'pending',
                    'bg-sky-100 text-sky-800' => $order->status === 'confirmed',
                    'bg-accent/10 text-accent' => $order->status === 'in_progress',
                    'bg-green-100 text-green-700' => $order->status === 'completed',
                    'bg-red-100 text-red-700' => $order->status === 'cancelled',
                ])>{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
            </div>

            <div class="grid grid-cols-3 gap-4 text-sm">
                <div><span class="text-muted">Order Type</span><p class="mb-0 capitalize font-medium text-navy">{{ $order->type }}</p></div>
                <div><span class="text-muted">Total</span><p class="mb-0 font-bold text-accent text-lg">R {{ number_format($order->total, 2) }}</p></div>
                <div><span class="text-muted">Placed</span><p class="mb-0 text-navy">{{ $order->created_at->format('d M Y, H:i') }}</p></div>
            </div>

            @if($order->notes)
            <div class="mt-4 p-3 bg-slate-50 rounded-lg">
                <span class="text-muted text-xs">Notes:</span>
                <p class="mb-0 text-sm text-navy">{{ $order->notes }}</p>
            </div>
            @endif
        </div>

        {{-- Order Items --}}
        @if($order->items->count())
        <div class="card-brand mb-4">
            <div class="px-6 py-4 border-b border-slate-100 font-bold text-navy">Items Ordered</div>
            <div class="divide-y divide-slate-100">
                @foreach($order->items as $item)
                <div class="flex justify-between px-6 py-3">
                    <div>
                        <p class="mb-0 font-medium text-navy">{{ $item->orderable?->title ?? 'Item #' . $item->orderable_id }}</p>
                        <small class="text-muted">Qty: {{ $item->quantity }}</small>
                    </div>
                    <p class="mb-0 font-bold text-navy">R {{ number_format($item->subtotal, 2) }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Shipment Tracking --}}
        @if($order->shipment)
        <div class="card-brand mb-4">
            <div class="px-6 py-4 border-b border-slate-100 font-bold text-navy">Shipment Status</div>
            <div class="p-6">
                <div class="flex justify-between mb-2">
                    <div>
                        <p class="mb-0"><strong class="text-navy">{{ $order->shipment->origin }}</strong> &rarr; <strong class="text-navy">{{ $order->shipment->destination }}</strong></p>
                        @if($order->shipment->vehicle)<small class="text-muted">Vehicle: {{ $order->shipment->vehicle->name }}</small>@endif
                    </div>
                    <span @class([
                        'badge-brand text-sm',
                        'bg-amber-100 text-amber-800' => $order->shipment->status === 'pending',
                        'bg-sky-100 text-sky-800' => $order->shipment->status === 'assigned',
                        'bg-accent/10 text-accent' => $order->shipment->status === 'in_transit',
                        'bg-green-100 text-green-700' => $order->shipment->status === 'delivered',
                        'bg-red-100 text-red-700' => $order->shipment->status === 'cancelled',
                    ])>{{ ucfirst(str_replace('_',' ',$order->shipment->status)) }}</span>
                </div>
                @if($order->shipment->pickup_date)<p class="mb-1 text-sm text-muted"><i class="bi bi-calendar me-1"></i>Pickup: {{ $order->shipment->pickup_date->format('d M Y') }}</p>@endif
                @if($order->shipment->delivery_date)<p class="mb-1 text-sm text-muted"><i class="bi bi-calendar-check me-1"></i>Expected Delivery: {{ $order->shipment->delivery_date->format('d M Y') }}</p>@endif
                @if($order->shipment->tracking_notes)
                <div class="mt-3 p-3 bg-slate-50 rounded-lg">
                    <span class="text-muted text-xs font-bold">Tracking Updates:</span>
                    <p class="mb-0 text-sm mt-1 whitespace-pre-line text-navy">{{ $order->shipment->tracking_notes }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        <div class="text-center mt-6 flex justify-center gap-3">
            <a href="{{ url('/') }}" class="btn-brand-outline">Back to Home</a>
            <a href="{{ route('marketplace.index') }}" class="btn-brand-primary">Browse Marketplace</a>
        </div>
    </div>
</section>
@endsection
