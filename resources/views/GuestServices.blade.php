@extends('layouts.public')

@section('title', 'Our Services — Nobela Enterprises')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="section-title text-center mb-5" data-aos="fade-up">
            <h2>Our Services</h2>
            <p>Professional industrial and logistics services tailored to your needs.</p>
        </div>

        <div class="row">
            {{-- Sidebar Filters --}}
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Categories</h5>
                        <div class="list-group list-group-flush">
                            <a href="{{ route('services.public') }}" class="list-group-item list-group-item-action {{ !$categorySlug ? 'active' : '' }}">All Services</a>
                            @foreach($categories as $cat)
                            <a href="{{ route('services.public', ['category' => $cat->slug]) }}" class="list-group-item list-group-item-action {{ $categorySlug === $cat->slug ? 'active' : '' }}">
                                {{ $cat->name }} <span class="badge bg-secondary float-end">{{ $cat->services_count }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Services --}}
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">{{ $categorySlug ? ucfirst(str_replace('-',' ',$categorySlug)) : 'All Services' }}</h4>
                    <form method="GET" action="{{ route('services.public') }}" class="d-flex gap-2">
                        @if($categorySlug)<input type="hidden" name="category" value="{{ $categorySlug }}">@endif
                        <input type="search" name="search" value="{{ $search ?? '' }}" class="form-control form-control-sm" placeholder="Search services...">
                        <button class="btn btn-sm btn-primary">Search</button>
                    </form>
                </div>

                @if($services->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">⚙️</div>
                        <h5>No services found</h5>
                        <p class="mt-2">{{ $search ? 'Try a different search term.' : 'No services in this category yet.' }}</p>
                        @if($search || $categorySlug)
                            <a href="{{ route('services.public') }}" class="btn btn-outline-primary mt-3">Clear filters</a>
                        @endif
                    </div>
                @else
                    <div class="row g-4">
                        @foreach($services as $service)
                        <div class="col-md-6 col-lg-4" data-aos="fade-up">
                            <div class="card h-100 border-0 shadow-sm">
                                @if($service->images->count())
                                    <img src="{{ asset($service->images->first()->image_path) }}" class="card-img-top" style="height:200px;object-fit:cover" alt="{{ $service->title }}">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px">
                                        <i class="bi bi-gear fs-1 text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column">
                                    @if($service->category)<span class="badge bg-primary align-self-start mb-2">{{ $service->category->name }}</span>@endif
                                    <h5 class="card-title">{{ $service->title }}</h5>
                                    <p class="card-text text-muted flex-grow-1">{{ Str::limit($service->description, 90) }}</p>
                                    @if($service->price)
                                        <p class="fw-bold text-primary mb-2">R {{ number_format($service->price, 2) }}</p>
                                    @else
                                        <p class="text-muted small mb-2">Price on request</p>
                                    @endif
                                    @if($service->vendor)<p class="text-muted small mb-2"><i class="bi bi-shop me-1"></i>{{ $service->vendor->business_name }}</p>@endif
                                    <a href="{{ route('services.show.public', $service) }}" class="btn btn-outline-primary btn-sm mt-auto">View & Request</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4">{{ $services->withQueryString()->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
