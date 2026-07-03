@props(['product'])

<div {{ $attributes->merge(['class' => 'card-brand h-full']) }} data-aos="fade-up">
    @if($product->images->count())
        <img src="{{ asset($product->images->first()->image_path) }}" class="w-full h-44 object-cover" alt="{{ $product->title }}">
    @else
        <div class="w-full h-44 bg-slate-100 flex items-center justify-center">
            <i class="bi bi-box-seam text-4xl text-muted"></i>
        </div>
    @endif

    <div class="flex flex-col flex-1 p-4">
        <h6 class="font-heading font-bold text-navy mb-1 text-sm">{{ \Illuminate\Support\Str::limit($product->title, 55) }}</h6>

        @if($product->category)
            <span class="badge-brand bg-slate-100 text-slate-600 mb-2 self-start">{{ $product->category->name }}</span>
        @endif

        <x-public.rating-stars :rating="$product->reviews_avg_rating ?? 0" :count="$product->reviews_count ?? 0" class="mb-2" />

        <p class="text-xs text-muted mb-3">{{ $product->vendor?->business_name ?? 'Trusted supplier' }}</p>

        <div class="mt-auto flex items-center justify-between gap-3">
            <span class="font-bold text-accent whitespace-nowrap">R {{ number_format($product->price, 2) }}</span>
            <a href="{{ route('marketplace.show', $product) }}" class="btn-brand-outline btn-brand-sm">View</a>
        </div>
    </div>
</div>
