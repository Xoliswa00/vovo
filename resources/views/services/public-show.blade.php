@extends('layouts.public')

@section('title', $service->title . ' — Nobela Enterprises')

@section('content')
<section class="py-5">
    <div class="container">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('services.public') }}">Services</a></li>
                @if($service->category)<li class="breadcrumb-item"><a href="{{ route('services.public', ['category'=>$service->category->slug]) }}">{{ $service->category->name }}</a></li>@endif
                <li class="breadcrumb-item active">{{ $service->title }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            {{-- Images --}}
            <div class="col-lg-6">
                @if($service->images->count())
                    <div id="serviceCarousel" class="carousel slide shadow rounded" data-bs-ride="carousel">
                        <div class="carousel-inner rounded">
                            @foreach($service->images as $i => $img)
                            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}">
                                <img src="{{ asset($img->image_path) }}" class="d-block w-100" style="height:400px;object-fit:cover" alt="{{ $service->title }}">
                            </div>
                            @endforeach
                        </div>
                        @if($service->images->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#serviceCarousel" data-bs-slide="prev"><span class="carousel-control-prev-icon"></span></button>
                            <button class="carousel-control-next" type="button" data-bs-target="#serviceCarousel" data-bs-slide="next"><span class="carousel-control-next-icon"></span></button>
                        @endif
                    </div>
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:400px">
                        <i class="bi bi-gear fs-1 text-muted"></i>
                    </div>
                @endif
            </div>

            {{-- Info & Order --}}
            <div class="col-lg-6">
                @if($service->category)<span class="badge bg-primary mb-2">{{ $service->category->name }}</span>@endif
                <h1 class="fw-bold">{{ $service->title }}</h1>
                @if($service->vendor)<p class="text-muted"><i class="bi bi-shop me-1"></i>Provided by <strong>{{ $service->vendor->business_name }}</strong></p>@endif
                @if($service->location)<p class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $service->location }}</p>@endif

                @if($service->price)
                    <h2 class="text-primary fw-bold my-3">R {{ number_format($service->price, 2) }}</h2>
                @else
                    <p class="badge bg-secondary fs-6 my-3">Price on Request</p>
                @endif

                @if($service->description)<p>{{ $service->description }}</p>@endif

                <hr>
                <h5 class="fw-bold">Request this Service</h5>
                @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
                <form method="POST" action="{{ route('services.order', $service) }}" class="mt-3">
                    @csrf
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input type="text" name="client_name" value="{{ old('client_name') }}" class="form-control @error('client_name') is-invalid @enderror" placeholder="Your name *" required>
                        </div>
                        <div class="col-md-6">
                            <input type="email" name="client_email" value="{{ old('client_email') }}" class="form-control @error('client_email') is-invalid @enderror" placeholder="Email *" required>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="client_phone" value="{{ old('client_phone') }}" class="form-control" placeholder="Phone">
                        </div>
                        <div class="col-12">
                            <textarea name="notes" class="form-control" placeholder="Describe your requirements..." rows="3">{{ old('notes') }}</textarea>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary px-5">Submit Request</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Reviews --}}
        <div class="row mt-5">
            <div class="col-lg-8">
                <h4 class="fw-bold mb-4">Reviews ({{ $service->reviews->count() }})</h4>
                @forelse($service->reviews as $review)
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
                        <form method="POST" action="{{ route('reviews.store', ['type'=>'service','id'=>$service->id]) }}">
                            @csrf
                            <div class="row g-2">
                                <div class="col-md-6"><input type="text" name="reviewer_name" value="{{ old('reviewer_name') }}" class="form-control" placeholder="Your name *" required></div>
                                <div class="col-md-6"><input type="email" name="reviewer_email" value="{{ old('reviewer_email') }}" class="form-control" placeholder="Email *" required></div>
                                <div class="col-12">
                                    <select name="rating" class="form-select" required>
                                        <option value="">— Select Rating —</option>
                                        @for($i=5;$i>=1;$i--)<option value="{{ $i }}">{{ $i }} Stars</option>@endfor
                                    </select>
                                </div>
                                <div class="col-12"><textarea name="comment" class="form-control" placeholder="Your review..." rows="3">{{ old('comment') }}</textarea></div>
                                <div class="col-12"><button type="submit" class="btn btn-outline-primary">Submit Review</button></div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
