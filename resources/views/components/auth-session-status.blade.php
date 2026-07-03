@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm font-medium px-4 py-3']) }}>
        {{ $status }}
    </div>
@endif
