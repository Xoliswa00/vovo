@extends('layouts.public')

@section('title', 'Nobela Enterprises — Logistics & Marketplace')
@section('meta_description', 'Professional logistics, freight, and marketplace services for your business.')

@section('content')

{{-- Hero --}}
<section id="hero" class="hero section dark-background">
    <div class="container d-flex flex-column align-items-center text-center py-5">
        <div data-aos="fade-up" data-aos-delay="100">
            <h1 class="display-4 fw-bold text-white mb-3">Logistics & Marketplace Solutions</h1>
            <p class="lead text-white-50 mb-4">Fast freight, reliable shipments, and a marketplace for industrial services and products — all in one place.</p>
            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('quote.create') }}" class="btn btn-primary btn-lg px-4">Get a Logistics Quote</a>
                <a href="{{ route('marketplace.index') }}" class="btn btn-outline-light btn-lg px-4">Browse Marketplace</a>
            </div>
        </div>
    </div>
</section>

{{-- Features Strip --}}
<section class="py-4 bg-primary text-white">
    <div class="container">
        <div class="row text-center gy-3">
            <div class="col-md-3"><i class="bi bi-truck me-2"></i> Real-time Shipment Tracking</div>
            <div class="col-md-3"><i class="bi bi-shield-check me-2"></i> Insured Cargo</div>
            <div class="col-md-3"><i class="bi bi-shop me-2"></i> Trusted Marketplace</div>
            <div class="col-md-3"><i class="bi bi-headset me-2"></i> 24/7 Support</div>
        </div>
    </div>
</section>

{{-- Featured Services --}}
@if($featuredServices->count())
<section class="py-5" id="services">
    <div class="container" data-aos="fade-up">
        <div class="section-title text-center mb-5">
            <h2>Our Services</h2>
            <p>Professional industrial and logistics services tailored to your needs.</p>
        </div>
        <div class="row g-4">
            @foreach($featuredServices as $service)
            <div class="col-md-6 col-lg-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card h-100 shadow-sm border-0">
                    @if($service->images->count())
                        <img src="{{ asset($service->images->first()->image_path) }}" class="card-img-top" style="height:200px;object-fit:cover" alt="{{ $service->title }}">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px">
                            <i class="bi bi-gear fs-1 text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        @if($service->category)
                            <span class="badge bg-primary mb-2 align-self-start">{{ $service->category->name }}</span>
                        @endif
                        <h5 class="card-title">{{ $service->title }}</h5>
                        <p class="card-text text-muted flex-grow-1">{{ Str::limit($service->description, 100) }}</p>
                        @if($service->price)
                            <p class="fw-bold text-primary mb-2">R {{ number_format($service->price, 2) }}</p>
                        @endif
                        <a href="{{ route('services.show.public', $service) }}" class="btn btn-outline-primary btn-sm mt-auto">View Service</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('services.public') }}" class="btn btn-primary px-5">All Services</a>
        </div>
    </div>
</section>
@endif

{{-- Logistics CTA --}}
<section class="py-5 bg-dark text-white">
    <div class="container" data-aos="fade-up">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2 class="fw-bold mb-2">Need Freight or Logistics?</h2>
                <p class="text-white-50 mb-0">Get a quote in minutes. We handle everything from small deliveries to heavy freight across South Africa.</p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="{{ route('quote.create') }}" class="btn btn-primary btn-lg px-5">Request a Quote</a>
            </div>
        </div>
    </div>
</section>

{{-- Marketplace Products --}}
@if($featuredProducts->count())
<section class="py-5" id="marketplace">
    <div class="container" data-aos="fade-up">
        <div class="section-title text-center mb-5">
            <h2>Marketplace</h2>
            <p>Browse industrial products and equipment from trusted vendors.</p>
        </div>
        <div class="row g-4">
            @foreach($featuredProducts as $product)
            <div class="col-6 col-md-4 col-lg-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                <div class="card h-100 shadow-sm border-0">
                    @if($product->images->count())
                        <img src="{{ asset($product->images->first()->image_path) }}" class="card-img-top" style="height:180px;object-fit:cover" alt="{{ $product->title }}">
                    @else
                        <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:180px">
                            <i class="bi bi-box-seam fs-1 text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column p-3">
                        <h6 class="card-title mb-1">{{ Str::limit($product->title, 50) }}</h6>
                        <p class="fw-bold text-primary mb-2 mt-auto">R {{ number_format($product->price, 2) }}</p>
                        <a href="{{ route('marketplace.show', $product) }}" class="btn btn-sm btn-outline-primary">View</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4">
            <a href="{{ route('marketplace.index') }}" class="btn btn-primary px-5">Browse All Products</a>
        </div>
    </div>
</section>
@endif

{{-- Why Us --}}
<section class="py-5 bg-light">
    <div class="container" data-aos="fade-up">
        <div class="section-title text-center mb-5">
            <h2>Why Choose Nobela</h2>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-4">
                <i class="bi bi-geo-alt-fill fs-1 text-primary mb-3"></i>
                <h5>Wide Coverage</h5>
                <p class="text-muted">We operate across South Africa with a growing fleet and partner network.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-clock-history fs-1 text-primary mb-3"></i>
                <h5>On-Time Delivery</h5>
                <p class="text-muted">We understand deadlines. Our tracking keeps you informed every step of the way.</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-patch-check-fill fs-1 text-primary mb-3"></i>
                <h5>Trusted Vendors</h5>
                <p class="text-muted">Every marketplace vendor is verified to ensure quality and reliability.</p>
            </div>
        </div>
    </div>
</section>

@endsection
