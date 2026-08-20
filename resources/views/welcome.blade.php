@extends('layouts.public')

@section('title', 'Nobela Enterprises — Logistics & Marketplace')
@section('meta_description', 'Professional logistics, freight, and marketplace services for your business.')

@section('content')

{{-- Hero --}}
<x-public.hero />

{{-- Stat band --}}
<section class="py-6 border-y border-slate-100" style="background: var(--surface-strong);">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-wrap justify-center gap-x-16 gap-y-4 text-center">
            <div class="stat-band-item">
                <strong>24/7</strong>
                <span>Support</span>
            </div>
            @if($vendorCount >= 20)
                <div class="stat-band-item">
                    <strong>{{ $vendorCount }}+</strong>
                    <span>Verified vendors</span>
                </div>
            @endif
            @if($avgRating >= 0.5)
                <div class="stat-band-item">
                    <strong>{{ $avgRating }}★</strong>
                    <span>Average rating</span>
                </div>
            @endif
        </div>
    </div>
</section>

{{-- Why businesses trust Nobela: bento --}}
<section class="py-16 bg-soft">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="section-title text-center mb-12">
            <h2>Why businesses trust Nobela</h2>
            <p>From freight logistics to verified marketplace goods, we deliver consistency, speed, and transparency.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bento-tile bento-tile-dark lg:col-span-2">
                <i class="bi bi-shop text-3xl mb-3"></i>
                <h5 class="mb-2">A marketplace you can actually verify</h5>
                <p class="mb-0">Every vendor is checked before their catalog goes live, so what you see is who you're buying from.</p>
            </div>
            <div class="bento-tile">
                <i class="bi bi-truck text-3xl text-accent mb-3"></i>
                <h5 class="mb-2">Real-time tracking</h5>
                <p class="mb-0">See every shipment milestone from pickup to delivery.</p>
            </div>
            <div class="bento-tile bento-tile-accent">
                <i class="bi bi-shield-check text-3xl mb-3"></i>
                <h5 class="mb-2">Insured cargo</h5>
                <p class="mb-0">Your goods are protected on every shipment we handle.</p>
            </div>
            <div class="bento-tile lg:col-span-2">
                <i class="bi bi-geo-alt text-3xl text-accent mb-3"></i>
                <h5 class="mb-2">Coverage across South Africa</h5>
                <p class="mb-0">A growing fleet and partner network, not a single depot pretending otherwise.</p>
            </div>
            <div class="bento-tile lg:col-span-2">
                <i class="bi bi-clock-history text-3xl text-accent mb-3"></i>
                <h5 class="mb-2">On-time, and we tell you if we won't be</h5>
                <p class="mb-0">Clear status updates from booking to delivery, no guessing where your shipment is.</p>
            </div>
        </div>
    </div>
</section>

{{-- Featured Services --}}
@if($featuredServices->count())
<section class="py-16" id="services">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-up">
        <div class="section-title text-center mb-12">
            <h2>Featured services for your business</h2>
            <p>Explore specialised logistics and industrial services built around reliability and speed.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($featuredServices as $service)
                <x-public.service-card :service="$service" data-aos-delay="{{ $loop->index * 100 }}" />
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('services.public') }}" class="btn-brand-primary">Explore all services</a>
        </div>
    </div>
</section>
@endif

{{-- Logistics CTA --}}
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-up">
        <div class="cta-box rounded-3xl shadow-xl text-white overflow-hidden p-8 lg:p-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                <div class="lg:col-span-8">
                    <h2 class="text-2xl font-bold font-heading mb-3">Need freight or logistics support?</h2>
                    <p class="text-white/75">Get a quote in minutes. We handle everything from small deliveries to heavy freight across South Africa, with end-to-end visibility.</p>
                </div>
                <div class="lg:col-span-4 lg:text-right">
                    <a href="{{ route('quote.create') }}" class="inline-flex items-center justify-center rounded-full px-8 py-3 text-sm font-bold uppercase tracking-wide bg-white text-navy hover:-translate-y-0.5 transition-transform">Request a Quote</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Marketplace Products --}}
@if($featuredProducts->count())
<section class="py-16" id="marketplace">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" data-aos="fade-up">
        <div class="section-title text-center mb-12">
            <h2>Marketplace highlights</h2>
            <p>Browse industrial products and equipment from trusted vendors, ready for your next project.</p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <x-public.product-card :product="$product" data-aos-delay="{{ $loop->index * 50 }}" />
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('marketplace.index') }}" class="btn-brand-primary">Browse All Products</a>
        </div>
    </div>
</section>
@endif

@endsection
