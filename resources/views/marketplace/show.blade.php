@extends('layouts.public')

@section('title', $product->title . ' — Nobela Marketplace')

@section('content')
<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('marketplace.index') }}">Marketplace</a></li>
                @if($product->category)<li class="breadcrumb-item"><a href="{{ route('marketplace.index', ['category'=>$product->category->slug]) }}">{{ $product->category->name }}</a></li>@endif
                <li class="breadcrumb-item active">{{ $product->title }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            {{-- Images --}}
            <div class="col-lg-6">
                @if($product->images->count())
                    <div id="productCarousel" class="carousel slide shadow rounded" data-bs-ride="carousel">
                        <div class="carousel-inner rounded">
                            @foreach($product->images as $i => $img)
                            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                <img src="{{ asset($img->image_path) }}" class="d-block w-100" style="height:400px;object-fit:cover" alt="{{ $product->title }}">
                            </div>
                            @endforeach
                        </div>
                        @if($product->images->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
                        @endif
                    </div>
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:400px">
                        <i class="bi bi-box-seam fs-1 text-muted"></i>
                    </div>
                @endif
            </div>

            {{-- Info & Order --}}
            <div class="col-lg-6">
                @if($product->category)<span class="badge bg-primary mb-2">{{ $product->category->name }}</span>@endif
                <h1 class="fw-bold">{{ $product->title }}</h1>
                @if($product->vendor)<p class="text-muted"><i class="bi bi-shop me-1"></i>Sold by <strong>{{ $product->vendor->business_name }}</strong></p>@endif

                <h2 class="text-primary fw-bold my-3">R {{ number_format($product->price, 2) }}</h2>

                <p class="text-muted">Stock: <strong>{{ $product->stock > 0 ? $product->stock . ' available' : 'Out of stock' }}</strong></p>

                @if($product->description)<p>{{ $product->description }}</p>@endif

                @if($product->stock > 0)
                <hr>
                <h5 class="fw-bold">Place Order</h5>
                <form method="POST" action="{{ route('marketplace.order', $product) }}" class="mt-3">
                    @csrf
                    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="text" name="client_name" value="{{ old('client_name') }}" class="form-control @error('client_name') is-invalid @enderror" placeholder="Your name *" required>
                            @error('client_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="client_email" value="{{ old('client_email') }}" class="form-control @error('client_email') is-invalid @enderror" placeholder="Email *" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="client_phone" value="{{ old('client_phone') }}" class="form-control" placeholder="Phone">
                        </div>
                        <div class="col-md-6">
                            <input type="number" name="quantity" value="{{ old('quantity', 1) }}" class="form-control" min="1" max="{{ $product->stock }}" placeholder="Qty" required>
                        </div>
                        <div class="col-12">
                            <textarea name="notes" class="form-control" placeholder="Any special instructions?" rows="2">{{ old('notes') }}</textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary px-5">Order Now</button>
                        </div>
                    </div>
                </form>
                @endif
            </div>
        </div>

        {{-- Reviews --}}
        <div class="row mt-5">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-4">Reviews ({{ $product->reviews->count() }})</h4>
                @forelse($product->reviews as $review)
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-1">
                            <strong>{{ $review->reviewer_name }}</strong>
                            <span class="text-warning">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5-$review->rating) }}</span>
                        </div>
                        @if($review->comment)<p class="mb-0 text-muted">{{ $review->comment }}</p>@endif
                    </div>
                </div>
                @empty
                <p class="text-muted">No reviews yet. Be the first!</p>
                @endforelse

                <div class="card border-0 shadow-sm mt-4">
                    <div class="card-body">
                        <h5 class="fw-bold mb-3">Leave a Review</h5>
                        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                        <form method="POST" action="{{ route('reviews.store', ['type'=>'product','id'=>$product->id]) }}">
                            @csrf
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input type="text" name="reviewer_name" value="{{ old('reviewer_name') }}" class="form-control" placeholder="Your name *" required>
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="reviewer_email" value="{{ old('reviewer_email') }}" class="form-control" placeholder="Email *" required>
                                </div>
                                <div class="col-12">
                                    <select name="rating" class="form-select" required>
                                        <option value="">— Select Rating —</option>
                                        @for($i=5;$i>=1;$i--)<option value="{{ $i }}">{{ $i }} Stars</option>@endfor
                                    </select>
                                </div>
                                <div class="col-12">
                                    <textarea name="comment" class="form-control" placeholder="Your review..." rows="3">{{ old('comment') }}</textarea>
                                </div>
                                <div class="col-12"><button type="submit" class="btn btn-outline-primary">Submit Review</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Products --}}
        @if($related->count())
        <div class="mt-5">
            <h4 class="fw-bold mb-4">Related Products</h4>
            <div class="row g-4">
                @foreach($related as $rel)
                <div class="col-6 col-md-3">
                    <div class="card h-100 border-0 shadow-sm">
                        @if($rel->images->count())
                            <img src="{{ asset($rel->images->first()->image_path) }}" class="card-img-top" style="height:150px;object-fit:cover" alt="{{ $rel->title }}">
                        @endif
                        <div class="card-body p-2">
                            <h6 class="card-title small">{{ Str::limit($rel->title, 40) }}</h6>
                            <p class="fw-bold text-primary small mb-1">R {{ number_format($rel->price,2) }}</p>
                            <a href="{{ route('marketplace.show', $rel) }}" class="btn btn-sm btn-outline-primary w-100">View</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
