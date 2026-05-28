@extends('layouts.public')

@section('title', 'About Us — Nobela Enterprises')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row gy-5 align-items-center">
            <div class="col-lg-6" data-aos="fade-right">
                <h2 class="fw-bold mb-3">Who We Are</h2>
                <p>Nobela Enterprises is located in the heart of Gauteng. We specialize in reliable freight and logistics solutions as well as a curated marketplace for industrial services and products.</p>
                <p>We connect businesses with trusted service providers and streamline the movement of goods — from small parcels to heavy freight — across South Africa.</p>

                <h5 class="fw-bold mt-4 mb-2">Mission & Vision</h5>
                <p><strong>Mission:</strong> To deliver efficient, reliable logistics and a trusted marketplace that empowers businesses of all sizes.</p>
                <p><strong>Vision:</strong> To be the leading logistics and industrial marketplace platform in Southern Africa, built on integrity and service excellence.</p>

                <div class="d-flex gap-3 mt-4">
                    <a href="{{ route('quote.create') }}" class="btn btn-primary px-4">Get a Quote</a>
                    <a href="{{ route('marketplace.index') }}" class="btn btn-outline-primary px-4">Browse Marketplace</a>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left">
                <div class="row g-3">
                    <div class="col-6">
                        <div class="card border-0 shadow-sm text-center p-4">
                            <i class="bi bi-truck fs-1 text-primary mb-2"></i>
                            <h5>Freight & Logistics</h5>
                            <p class="text-muted small">Nationwide delivery with real-time tracking</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-0 shadow-sm text-center p-4">
                            <i class="bi bi-shop fs-1 text-primary mb-2"></i>
                            <h5>Marketplace</h5>
                            <p class="text-muted small">Trusted vendors, quality industrial products</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-0 shadow-sm text-center p-4">
                            <i class="bi bi-tools fs-1 text-primary mb-2"></i>
                            <h5>Boilermaking</h5>
                            <p class="text-muted small">Precision steel fabrication and engineering</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card border-0 shadow-sm text-center p-4">
                            <i class="bi bi-headset fs-1 text-primary mb-2"></i>
                            <h5>24/7 Support</h5>
                            <p class="text-muted small">We're always available when you need us</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="row text-center mt-5 g-4" data-aos="fade-up">
            <div class="col-md-3">
                <h2 class="fw-bold text-primary purecounter">150+</h2>
                <p class="text-muted">Shipments Completed</p>
            </div>
            <div class="col-md-3">
                <h2 class="fw-bold text-primary">50+</h2>
                <p class="text-muted">Trusted Vendors</p>
            </div>
            <div class="col-md-3">
                <h2 class="fw-bold text-primary">9</h2>
                <p class="text-muted">Provinces Covered</p>
            </div>
            <div class="col-md-3">
                <h2 class="fw-bold text-primary">100%</h2>
                <p class="text-muted">Commitment to Quality</p>
            </div>
        </div>

        {{-- Contact --}}
        <div class="mt-5 p-5 bg-dark text-white rounded" data-aos="fade-up" id="contact">
            <div class="row">
                <div class="col-md-6">
                    <h4 class="fw-bold mb-3">Get in Touch</h4>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> 120 Rietfontein Road, Germiston, Gauteng</li>
                        <li class="mb-2"><i class="bi bi-telephone me-2"></i> +27 82 123 4567</li>
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i> info@nobelaenterprises.co.za</li>
                    </ul>
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <div>
                        <p class="lead">Ready to work with us?</p>
                        <a href="{{ route('quote.create') }}" class="btn btn-primary px-4 me-2">Request a Quote</a>
                        <a href="{{ route('services.public') }}" class="btn btn-outline-light px-4">Our Services</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
