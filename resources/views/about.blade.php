@extends('layouts.public')

@section('title', 'About Us — Nobela Enterprises')
@section('meta_description', 'Learn about Nobela Enterprises, a South African logistics and marketplace company delivering freight, boilermaking, and verified vendor services with speed and transparency.')

@section('content')
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div data-aos="fade-right">
                <h2 class="text-2xl font-bold font-heading text-navy mb-3">Who We Are</h2>
                <p class="text-muted mb-4">Nobela Enterprises is located in the heart of Gauteng. We specialize in reliable freight and logistics solutions as well as a curated marketplace for industrial services and products.</p>
                <p class="text-muted mb-6">We connect businesses with trusted service providers and streamline the movement of goods, from small parcels to heavy freight, across South Africa.</p>

                <h5 class="font-bold font-heading text-navy mt-6 mb-2">Mission &amp; Vision</h5>
                <p class="text-muted mb-2"><strong class="text-navy">Mission:</strong> To deliver efficient, reliable logistics and a trusted marketplace that empowers businesses of all sizes.</p>
                <p class="text-muted mb-6"><strong class="text-navy">Vision:</strong> To be the leading logistics and industrial marketplace platform in Southern Africa, built on integrity and service excellence.</p>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('quote.create') }}" class="btn-brand-primary">Get a Quote</a>
                    <a href="{{ route('marketplace.index') }}" class="btn-brand-outline">Browse Marketplace</a>
                </div>
            </div>

            <div data-aos="fade-left">
                {{-- Real Nobela boilermaking work. TODO: add fleet/warehouse/team photos once available. --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="rounded-2xl overflow-hidden shadow-md">
                        <img src="{{ asset('assets/img/boilermaking-trailer-chassis-1.jpg') }}" class="w-full h-56 object-cover" alt="Custom trailer chassis fabricated and painted in-house">
                    </div>
                    <div class="rounded-2xl overflow-hidden shadow-md">
                        <img src="{{ asset('assets/img/boilermaking-trailer-chassis-2.jpg') }}" class="w-full h-56 object-cover" alt="Finished trailer chassis ready for assembly">
                    </div>
                    <div class="rounded-2xl overflow-hidden shadow-md">
                        <img src="{{ asset('assets/img/boilermaking-frame-weld.jpg') }}" class="w-full h-56 object-cover" alt="Welded steel frame joint on a trailer build">
                    </div>
                    <div class="rounded-2xl overflow-hidden shadow-md">
                        <img src="{{ asset('assets/img/boilermaking-axle-assembly.jpg') }}" class="w-full h-56 object-cover" alt="Trailer axle assembly under fabrication">
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center mt-16" data-aos="fade-up">
            <div>
                <h2 class="text-3xl font-extrabold font-heading text-accent">{{ $shipmentCount }}+</h2>
                <p class="text-muted text-sm">Shipments Completed</p>
            </div>
            <div>
                <h2 class="text-3xl font-extrabold font-heading text-accent">{{ $vendorCount }}+</h2>
                <p class="text-muted text-sm">Trusted Vendors</p>
            </div>
            <div>
                <h2 class="text-3xl font-extrabold font-heading text-accent">{{ $orderCount }}+</h2>
                <p class="text-muted text-sm">Orders Completed</p>
            </div>
            <div>
                <h2 class="text-3xl font-extrabold font-heading text-accent">{{ $avgRating > 0 ? $avgRating : '—' }}★</h2>
                <p class="text-muted text-sm">Average Rating</p>
            </div>
        </div>

        {{-- Contact --}}
        <div class="mt-16 p-8 lg:p-12 bg-navy text-white rounded-3xl" data-aos="fade-up" id="contact">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h4 class="text-xl font-bold font-heading mb-4">Get in Touch</h4>
                    <ul class="space-y-3 text-white/80">
                        <li><i class="bi bi-geo-alt text-accent-light me-2"></i> 120 Rietfontein Road, Germiston, Gauteng</li>
                        <li><i class="bi bi-telephone text-accent-light me-2"></i> +27 82 123 4567</li>
                        <li><i class="bi bi-envelope text-accent-light me-2"></i> info@nobelaenterprises.co.za</li>
                    </ul>
                </div>
                <div class="flex items-center">
                    <div>
                        <p class="text-lg mb-4">Ready to work with us?</p>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('quote.create') }}" class="btn-brand-primary">Request a Quote</a>
                            <a href="{{ route('services.public') }}" class="btn-brand-outline-light">Our Services</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
