@extends('layouts.public')

@section('title', $service->title . ' — Nobela Enterprises')
@section('meta_description', \Illuminate\Support\Str::limit($service->description ?: $service->title . ', a professional service from ' . ($service->vendor?->business_name ?? 'a trusted provider') . ', available via Nobela Enterprises.', 155))

@section('content')
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav aria-label="breadcrumb" class="mb-6 text-sm text-muted">
            <a href="{{ route('services.public') }}" class="hover:text-accent">Services</a>
            @if($service->category)<span class="mx-1">/</span><a href="{{ route('services.public', ['category'=>$service->category->slug]) }}" class="hover:text-accent">{{ $service->category->name }}</a>@endif
            <span class="mx-1">/</span><span class="text-navy font-medium">{{ $service->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            {{-- Images --}}
            <div>
                @if($service->images->count())
                    <div x-data="{ active: 0 }">
                        <div class="rounded-2xl overflow-hidden shadow-lg relative bg-slate-100">
                            @foreach($service->images as $i => $img)
                                <img x-show="active === {{ $i }}" src="{{ asset($img->image_path) }}" class="w-full h-[420px] object-cover" alt="{{ $service->title }}">
                            @endforeach
                            @if($service->images->count() > 1)
                                <button type="button" @click="active = active === 0 ? {{ $service->images->count() - 1 }} : active - 1" class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/90 shadow flex items-center justify-center hover:bg-white" aria-label="Previous image">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button type="button" @click="active = active === {{ $service->images->count() - 1 }} ? 0 : active + 1" class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/90 shadow flex items-center justify-center hover:bg-white" aria-label="Next image">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            @endif
                        </div>
                        @if($service->images->count() > 1)
                            <div class="gallery-thumbs">
                                @foreach($service->images as $i => $img)
                                    <button type="button" @click="active = {{ $i }}" :class="active === {{ $i }} ? 'active' : ''" aria-label="View image {{ $i + 1 }}">
                                        <img src="{{ asset($img->image_path) }}" alt="">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <div class="rounded-2xl bg-slate-100 flex items-center justify-center h-[420px]">
                        <i class="bi bi-gear text-5xl text-muted"></i>
                    </div>
                @endif
            </div>

            {{-- Info & Request Box --}}
            <div>
                @if($service->category)<span class="badge-brand bg-accent text-white mb-2">{{ $service->category->name }}</span>@endif
                <h1 class="text-2xl font-bold font-heading text-navy mb-2">{{ $service->title }}</h1>
                <x-public.rating-stars :rating="$service->reviews_avg_rating ?? 0" :count="$service->reviews_count ?? 0" size="fs-6" class="mb-2" />
                @if($service->vendor)<p class="text-muted mb-1"><i class="bi bi-shop me-1"></i>Provided by <strong class="text-navy">{{ $service->vendor->business_name }}</strong></p>@endif
                @if($service->location)<p class="text-muted mb-3"><i class="bi bi-geo-alt me-1"></i>{{ $service->location }}</p>@endif

                @if($service->description)<p class="text-muted">{{ $service->description }}</p>@endif

                <div class="buy-box mt-4">
                    @if($service->price)
                        <h2 class="text-2xl font-bold font-heading text-accent mb-4">R {{ number_format($service->price, 2) }}</h2>
                    @else
                        <span class="stock-badge in-stock mb-4 inline-flex"><span class="dot"></span>Price on request</span>
                    @endif

                    <h6 class="font-bold font-heading text-navy mb-3">Request this service</h6>
                    @if(session('success'))<div class="alert-success-brand mb-3">{{ session('success') }}</div>@endif
                    <form method="POST" action="{{ route('services.order', $service) }}" class="space-y-3">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <input type="text" name="client_name" value="{{ old('client_name') }}" class="field-brand @error('client_name') field-brand-error @enderror" placeholder="Your name *" required>
                            <input type="email" name="client_email" value="{{ old('client_email') }}" class="field-brand @error('client_email') field-brand-error @enderror" placeholder="Email *" required>
                        </div>
                        <input type="text" name="client_phone" value="{{ old('client_phone') }}" class="field-brand" placeholder="Phone">
                        <textarea name="notes" class="field-brand" placeholder="Describe your requirements..." rows="3">{{ old('notes') }}</textarea>
                        <button type="submit" class="btn-brand-primary w-full">Submit Request</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Reviews --}}
        <div class="mt-16">
            <div class="lg:w-2/3">
                <div class="flex items-center gap-3 mb-6">
                    <h4 class="text-xl font-bold font-heading text-navy">Reviews</h4>
                    <x-public.rating-stars :rating="$service->reviews_avg_rating ?? 0" :count="$service->reviews_count ?? 0" />
                </div>
                @forelse($service->reviews as $review)
                <div class="card-brand p-5 mb-3">
                    <div class="flex justify-between mb-1">
                        <strong class="text-navy">{{ $review->reviewer_name }}</strong>
                        <span class="text-amber-500">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5-$review->rating) }}</span>
                    </div>
                    @if($review->comment)<p class="text-muted text-sm mb-0">{{ $review->comment }}</p>@endif
                </div>
                @empty
                <p class="text-muted">No reviews yet. Be the first!</p>
                @endforelse

                <div class="card-brand p-5 mt-4">
                    <h5 class="font-bold font-heading text-navy mb-3">Leave a Review</h5>
                    <form method="POST" action="{{ route('reviews.store', ['type'=>'service','id'=>$service->id]) }}" class="space-y-3">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <input type="text" name="reviewer_name" value="{{ old('reviewer_name') }}" class="field-brand" placeholder="Your name *" required>
                            <input type="email" name="reviewer_email" value="{{ old('reviewer_email') }}" class="field-brand" placeholder="Email *" required>
                        </div>
                        <select name="rating" class="field-brand" required>
                            <option value="">Select rating</option>
                            @for($i=5;$i>=1;$i--)<option value="{{ $i }}">{{ $i }} Stars</option>@endfor
                        </select>
                        <textarea name="comment" class="field-brand" placeholder="Your review..." rows="3">{{ old('comment') }}</textarea>
                        <button type="submit" class="btn-brand-outline">Submit Review</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
