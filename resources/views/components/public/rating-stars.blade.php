@props(['rating' => 0, 'count' => 0, 'size' => ''])

@php
    $rounded = round($rating * 2) / 2;
    $full = (int) floor($rounded);
    $half = ($rounded - $full) === 0.5;
    $empty = 5 - $full - ($half ? 1 : 0);
@endphp

<div {{ $attributes->class(['inline-flex items-center gap-2']) }}>
    <span class="rating-stars {{ $size }}" aria-hidden="true">
        @for($i = 0; $i < $full; $i++)<i class="bi bi-star-fill"></i>@endfor
        @if($half)<i class="bi bi-star-half"></i>@endif
        @for($i = 0; $i < $empty; $i++)<i class="bi bi-star"></i>@endfor
    </span>
    @if($count > 0)
        <span class="rating-count">{{ number_format($rating, 1) }} <span class="text-muted">({{ $count }})</span></span>
    @else
        <span class="rating-count text-muted">No reviews yet</span>
    @endif
</div>
