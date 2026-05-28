@extends('layouts.public')

@section('title', 'Marketplace — Nobela Enterprises')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row">

            {{-- Sidebar Filters --}}
            <div class="col-lg-3 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Filter by Category</h5>
                        <div class="list-group list-group-flush">
                            <a href="{{ route('marketplace.index') }}" class="list-group-item list-group-item-action {{ !$categorySlug ? 'active' : '' }}">
                                All Products <span class="badge bg-secondary float-end">{{ $categories->sum('products_count') }}</span>
                            </a>
                            @foreach($categories as $cat)
                            <a href="{{ route('marketplace.index', ['category' => $cat->slug]) }}" class="list-group-item list-group-item-action {{ $categorySlug === $cat->slug ? 'active' : '' }}">
                                {{ $cat->name }} <span class="badge bg-secondary float-end">{{ $cat->products_count }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Products --}}
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="fw-bold mb-0">{{ $categorySlug ? ucfirst(str_replace('-',' ',$categorySlug)) : 'All Products' }}</h4>
                    <form method="GET" action="{{ route('marketplace.index') }}" class="d-flex gap-2">
                        @if($categorySlug)<input type="hidden" name="category" value="{{ $categorySlug }}">@endif
                        <input type="search" name="search" value="{{ $search }}" class="form-control form-control-sm" placeholder="Search products...">
                        <button class="btn btn-sm btn-primary">Search</button>
                    </form>
                </div>

                @if($products->isEmpty())
                    <div class="empty-state">
                        <div class="empty-icon">📦</div>
                        <h5>No products found</h5>
                        <p class="mt-2">{{ $search ? 'Try a different search term or clear the filter.' : 'No products in this category yet.' }}</p>
                        @if($search || $categorySlug)
                            <a href="{{ route('marketplace.index') }}" class="btn btn-outline-primary mt-3">Clear filters</a>
                        @endif
                    </div>
                @else
                    <div class="row g-4">
                        @foreach($products as $product)
                        <div class="col-md-6 col-xl-4" data-aos="fade-up">
                            <div class="card h-100 border-0 shadow-sm">
                                @if($product->images->count())
                                    <img src="{{ asset($product->images->first()->image_path) }}" class="card-img-top" style="height:200px;object-fit:cover" alt="{{ $product->title }}">
                                @else
                                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height:200px">
                                        <i class="bi bi-box-seam fs-1 text-muted"></i>
                                    </div>
                                @endif
                                <div class="card-body d-flex flex-column">
                                    @if($product->category)
                                        <span class="badge bg-primary align-self-start mb-2">{{ $product->category->name }}</span>
                                    @endif
                                    <h6 class="card-title">{{ $product->title }}</h6>
                                    <p class="card-text text-muted small flex-grow-1">{{ Str::limit($product->description, 80) }}</p>
                                    @if($product->vendor)
                                        <p class="text-muted small mb-2"><i class="bi bi-shop me-1"></i>{{ $product->vendor->business_name }}</p>
                                    @endif
                                    <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                                        <span class="fw-bold text-primary fs-5">R {{ number_format($product->price, 2) }}</span>
                                        <a href="{{ route('marketplace.show', $product) }}" class="btn btn-sm btn-primary">View</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4">{{ $products->withQueryString()->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
