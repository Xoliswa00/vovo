@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-navy mb-1']) }}>
    {{ $value ?? $slot }}
</label>
