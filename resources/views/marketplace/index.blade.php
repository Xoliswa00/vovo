@extends('layouts.public')

@section('title', 'Marketplace — Nobela Enterprises')
@section('meta_description', 'Shop industrial products and equipment from verified vendors on the Nobela marketplace. Filter by category, compare prices, and order directly online.')

@section('content')
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

            {{-- Sidebar Filters --}}
            <div class="lg:col-span-3">
                <div class="card-brand sticky top-24 p-5">
                    <h5 class="font-bold font-heading text-navy mb-4">Filter by Category</h5>
                    <div class="space-y-1">
                        <a href="{{ route('marketplace.index') }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm {{ !$categorySlug ? 'bg-accent/10 text-accent font-semibold' : 'text-muted hover:bg-slate-50' }}">
                            All Products <span class="badge-brand bg-slate-100 text-slate-600">{{ $categories->sum('products_count') }}</span>
                        </a>
                        @foreach($categories as $cat)
                        <a href="{{ route('marketplace.index', ['category' => $cat->slug]) }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-sm {{ $categorySlug === $cat->slug ? 'bg-accent/10 text-accent font-semibold' : 'text-muted hover:bg-slate-50' }}">
                            {{ $cat->name }} <span class="badge-brand bg-slate-100 text-slate-600">{{ $cat->products_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Products --}}
            <div class="lg:col-span-9">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-3">
                    <div>
                        <h4 class="text-xl font-bold font-heading text-navy mb-1">{{ $categorySlug ? ucfirst(str_replace('-',' ',$categorySlug)) : 'All Products' }}</h4>
                        <p class="text-muted text-sm">Showing {{ $products->total() }} products {{ $categorySlug ? 'in '.ucfirst(str_replace('-',' ',$categorySlug)) : 'across the marketplace' }}.</p>
                    </div>
                    <form method="GET" action="{{ route('marketplace.index') }}" class="flex gap-2 w-full md:w-auto">
                        @if($categorySlug)<input type="hidden" name="category" value="{{ $categorySlug }}">@endif
                        <input type="search" name="search" value="{{ $search }}" class="rounded-lg border-gray-300 text-sm focus:border-accent focus:ring-accent" placeholder="Search products...">
                        <select name="sort" class="rounded-lg border-gray-300 text-sm focus:border-accent focus:ring-accent" style="max-width: 170px" onchange="this.form.submit()">
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
                        <a href="{{ route('marketplace.index', ['category' => $cat->slug]) }}" class="marketplace-category-pill">{{ $cat->name }} ({{ $cat->products_count }})</a>
                    @endforeach
                    @if($categories->count() > 6)
                        <a href="#filters" class="marketplace-category-pill">View all categories</a>
                    @endif
                </div>

                @if($products->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">📦</div>
                        <h5>No products found</h5>
                        <p class="mt-2">{{ $search ? 'Try a different search term or clear the filter.' : 'No products in this category yet.' }}</p>
                        @if($search || $categorySlug)
                            <a href="{{ route('marketplace.index') }}" class="btn-brand-outline mt-3">Clear filters</a>
                        @endif
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($products as $product)
                        <div class="relative" data-aos="fade-up">
                            <div class="card-brand h-full">
                                <div class="relative">
                                    @if($product->images->count())
                                        <img src="{{ asset($product->images->first()->image_path) }}" class="w-full h-56 object-cover" alt="{{ $product->title }}">
                                    @else
                                        <div class="w-full h-56 bg-slate-100 flex items-center justify-center">
                                            <i class="bi bi-box-seam text-4xl text-muted"></i>
                                        </div>
                                    @endif
                                    @if(!$product->price)
                                        <span class="product-badge">Quote required</span>
                                    @elseif($product->stock <= 0)
                                        <span class="product-badge">Out of stock</span>
                                    @endif
                                </div>
                                <div class="flex flex-col flex-1 p-5">
                                    @if($product->category)
                                        <span class="badge-brand bg-accent/10 text-accent self-start mb-2">{{ $product->category->name }}</span>
                                    @endif
                                    <h6 class="font-heading font-bold text-navy mb-2">{{ $product->title }}</h6>
                                    <x-public.rating-stars :rating="$product->reviews_avg_rating ?? 0" :count="$product->reviews_count ?? 0" class="mb-2" />
                                    <p class="text-sm text-muted flex-1 mb-3">{{ Str::limit($product->description, 80) }}</p>
                                    @if($product->vendor)
                                        <p class="text-xs text-muted mb-3"><i class="bi bi-shop me-1"></i>{{ $product->vendor->business_name }}</p>
                                    @endif
                                    <div class="flex justify-between items-center mt-auto pt-3 border-t border-slate-100">
                                        <span class="font-bold text-accent text-lg">@if($product->price) R {{ number_format($product->price, 2) }} @else On request @endif</span>
                                        <a href="{{ route('marketplace.show', $product) }}" class="btn-brand-primary btn-brand-sm">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-8">{{ $products->withQueryString()->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
