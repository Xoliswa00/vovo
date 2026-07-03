@extends('layouts.public')

@section('title', 'Track Your Order — Nobela Enterprises')
@section('meta_description', 'Track your Nobela Enterprises order or shipment. Enter your order number to see live status.')

@section('content')
<section class="py-16">
    <div class="max-w-lg mx-auto px-4 sm:px-6">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold font-heading text-navy">Track your order</h2>
            <p class="text-muted">Enter the order number from your confirmation to see its current status.</p>
        </div>

        <div class="buy-box">
            <form method="POST" action="{{ route('orders.track.lookup.submit') }}">
                @csrf
                <label for="order_number" class="block text-sm font-semibold text-navy mb-1">Order number</label>
                <input type="text" id="order_number" name="order_number" value="{{ old('order_number') }}" class="field-brand text-lg @error('order_number') field-brand-error @enderror" placeholder="e.g. ORD-AB12CD34" required autofocus>
                @error('order_number')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                <button type="submit" class="btn-brand-primary w-full mt-4">Track order</button>
            </form>
        </div>

        <p class="text-center text-sm text-muted mt-6">
            Your order number was shown when you placed your order or service request.
        </p>
    </div>
</section>
@endsection
