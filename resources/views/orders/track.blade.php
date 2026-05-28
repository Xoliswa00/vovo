@extends('layouts.public')

@section('title', 'Track Order ' . $order->order_number . ' — Nobela Enterprises')

@section('content')
<section class="py-5">
    <div class="container" style="max-width: 700px">
        <div class="text-center mb-4">
            <h2 class="fw-bold">Order Tracking</h2>
            <p class="text-muted">Order #<strong>{{ $order->order_number }}</strong></p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="mb-0">{{ $order->client_name }}</h5>
                        <small class="text-muted">{{ $order->client_email }}</small>
                    </div>
                    <span class="badge fs-6 {{ match($order->status) {
                        'pending' => 'bg-warning text-dark',
                        'confirmed' => 'bg-info',
                        'in_progress' => 'bg-primary',
                        'completed' => 'bg-success',
                        'cancelled' => 'bg-danger',
                        default => 'bg-secondary'
                    } }}">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                </div>

                <div class="row g-2 text-sm">
                    <div class="col-6"><small class="text-muted">Order Type</small><p class="mb-0 text-capitalize fw-medium">{{ $order->type }}</p></div>
                    <div class="col-6"><small class="text-muted">Total</small><p class="mb-0 fw-bold text-primary fs-5">R {{ number_format($order->total, 2) }}</p></div>
                    <div class="col-6"><small class="text-muted">Placed</small><p class="mb-0">{{ $order->created_at->format('d M Y, H:i') }}</p></div>
                </div>

                @if($order->notes)
                <div class="mt-3 p-3 bg-light rounded">
                    <small class="text-muted">Notes:</small>
                    <p class="mb-0 small">{{ $order->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Order Items --}}
        @if($order->items->count())
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-bold">Items Ordered</div>
            <div class="list-group list-group-flush">
                @foreach($order->items as $item)
                <div class="list-group-item d-flex justify-content-between">
                    <div>
                        <p class="mb-0 fw-medium">{{ $item->orderable?->title ?? 'Item #' . $item->orderable_id }}</p>
                        <small class="text-muted">Qty: {{ $item->quantity }}</small>
                    </div>
                    <p class="mb-0 fw-bold">R {{ number_format($item->subtotal, 2) }}</p>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Shipment Tracking --}}
        @if($order->shipment)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white fw-bold">Shipment Status</div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <div>
                        <p class="mb-0"><strong>{{ $order->shipment->origin }}</strong> → <strong>{{ $order->shipment->destination }}</strong></p>
                        @if($order->shipment->vehicle)<small class="text-muted">Vehicle: {{ $order->shipment->vehicle->name }}</small>@endif
                    </div>
                    <span class="badge {{ match($order->shipment->status) {
                        'pending' => 'bg-warning text-dark',
                        'assigned' => 'bg-info',
                        'in_transit' => 'bg-primary',
                        'delivered' => 'bg-success',
                        'cancelled' => 'bg-danger',
                        default => 'bg-secondary'
                    } }}">{{ ucfirst(str_replace('_',' ',$order->shipment->status)) }}</span>
                </div>
                @if($order->shipment->pickup_date)<p class="mb-1 small"><i class="bi bi-calendar me-1"></i>Pickup: {{ $order->shipment->pickup_date->format('d M Y') }}</p>@endif
                @if($order->shipment->delivery_date)<p class="mb-1 small"><i class="bi bi-calendar-check me-1"></i>Expected Delivery: {{ $order->shipment->delivery_date->format('d M Y') }}</p>@endif
                @if($order->shipment->tracking_notes)
                <div class="mt-3 p-3 bg-light rounded">
                    <small class="text-muted fw-bold">Tracking Updates:</small>
                    <p class="mb-0 small mt-1 whitespace-pre-line">{{ $order->shipment->tracking_notes }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ url('/') }}" class="btn btn-outline-primary me-2">Back to Home</a>
            <a href="{{ route('marketplace.index') }}" class="btn btn-primary">Browse Marketplace</a>
        </div>
    </div>
</section>
@endsection
