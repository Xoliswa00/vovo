@extends('layouts.public')

@section('title', 'Our Services — Nobela Enterprises')
@section('meta_description', 'Browse verified logistics, freight, and industrial services from trusted providers. Compare pricing and location, then request a quote in minutes.')

@section('content')
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="section-title text-center mb-10" data-aos="fade-up">
            <h2>Our Services</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Sidebar Filters --}}
            <div class="lg:col-span-3">
                <div class="card-brand sticky top-24 p-5">
                    <h5 class="font-bold font-heading text-navy mb-4">Categories</h5>
                    <div class="space-y-1">
                        <a href="{{ route('services.public') }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm {{ !$categorySlug ? 'bg-accent/10 text-accent font-semibold' : 'text-muted hover:bg-slate-50' }}">All Services</a>
                        @foreach($categories as $cat)
                        <a href="{{ route('services.public', ['category' => $cat->slug]) }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm {{ $categorySlug === $cat->slug ? 'bg-accent/10 text-accent font-semibold' : 'text-muted hover:bg-slate-50' }}">
                            {{ $cat->name }} <span class="badge-brand bg-slate-100 text-slate-600">{{ $cat->services_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Services --}}
            <div class="lg:col-span-9">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
                    <div>
                        <h4 class="text-xl font-bold font-heading text-navy mb-1">{{ $categorySlug ? ucfirst(str_replace('-',' ',$categorySlug)) : 'All Services' }}</h4>
                        <p class="text-muted text-sm">{{ $services->total() }} services available {{ $categorySlug ? 'in '.ucfirst(str_replace('-',' ',$categorySlug)) : 'for your business' }}.</p>
                    </div>
                    <form method="GET" action="{{ route('services.public') }}" class="flex gap-2 w-full md:w-auto">
                        @if($categorySlug)<input type="hidden" name="category" value="{{ $categorySlug }}">@endif
                        <input type="search" name="search" value="{{ $search ?? '' }}" class="field-brand" placeholder="Search services...">
                        <select name="sort" class="field-brand" style="max-width: 170px" onchange="this.form.submit()">
                            <option value="newest" {{ $sort === 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Price: low to high</option>
                            <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price: high to low</option>
                            <option value="rating" {{ $sort === 'rating' ? 'selected' : '' }}>Top rated</option>
                        </select>
                        <button class="btn-brand-primary btn-brand-sm whitespace-nowrap">Search</button>
                    </form>
                </div>

                <div class="flex flex-wrap gap-2 mb-6">
                    @foreach($categories->take(6) as $cat)
                        <a href="{{ route('services.public', ['category' => $cat->slug]) }}" class="marketplace-category-pill">{{ $cat->name }} ({{ $cat->services_count }})</a>
                    @endforeach
                    @if($categories->count() > 6)
                        <a href="#filters" class="marketplace-category-pill">View all categories</a>
                    @endif
                </div>

                @if($services->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">⚙️</div>
                        <h5>No services found</h5>
                        <p class="mt-2">{{ $search ? 'Try a different search term.' : 'No services in this category yet.' }}</p>
                        @if($search || $categorySlug)
                            <a href="{{ route('services.public') }}" class="btn-brand-outline mt-3">Clear filters</a>
                        @endif
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($services as $service)
                            <x-public.service-card :service="$service" />
                        @endforeach
                    </div>
                    <div class="mt-8">{{ $services->withQueryString()->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
