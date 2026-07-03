@props(['service'])

<div {{ $attributes->merge(['class' => 'card-brand h-full']) }} data-aos="zoom-in">
    <div class="relative">
        @if($service->images->count())
            <img src="{{ asset($service->images->first()->image_path) }}" class="w-full h-52 object-cover" alt="{{ $service->title }}">
        @else
            <div class="w-full h-52 bg-slate-100 flex items-center justify-center">
                <i class="bi bi-gear text-4xl text-muted"></i>
            </div>
        @endif

        <span class="service-badge absolute top-3 left-3">
            {{ $service->category?->name ?? 'Service' }}
        </span>
    </div>

    <div class="flex flex-col flex-1 p-6">
        <h5 class="font-heading font-bold text-navy mb-1">{{ $service->title }}</h5>
        <x-public.rating-stars :rating="$service->reviews_avg_rating ?? 0" :count="$service->reviews_count ?? 0" class="mb-2" />
        <p class="text-sm text-muted flex-1 mb-4">
            {{ \Illuminate\Support\Str::limit($service->description, 96) }}
        </p>

        <div class="flex items-center justify-between gap-3 mt-auto">
            @if($service->price)
                <span class="font-bold text-accent whitespace-nowrap">R {{ number_format($service->price, 2) }}</span>
            @else
                <span class="text-muted text-sm">Price on request</span>
            @endif

            <a href="{{ route('services.show.public', $service) }}" class="btn-brand-outline btn-brand-sm whitespace-nowrap">
                View Service
            </a>
        </div>
    </div>
</div>
