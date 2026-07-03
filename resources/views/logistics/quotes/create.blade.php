@extends('layouts.public')

@section('title', 'Request a Logistics Quote — Nobela Enterprises')
@section('meta_description', 'Request a free logistics or freight quote from Nobela Enterprises. Tell us your shipment details and get a competitive price with fast turnaround across South Africa.')

@section('content')
<section class="py-16 bg-soft">
    <div class="max-w-2xl mx-auto px-4 sm:px-6">
        <div class="text-center mb-8" data-aos="fade-up">
            <h2 class="text-2xl font-bold font-heading text-navy">Get a Logistics Quote</h2>
            <p class="text-muted">Tell us about your shipment and we'll get back to you with a competitive price.</p>
        </div>

        @if(session('success'))
            <div class="alert-success-brand mb-4">{{ session('success') }}</div>
        @endif

        <div class="card-brand p-6 sm:p-8" data-aos="fade-up" data-aos-delay="100">
            <form method="POST" action="{{ route('quote.store') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-navy mb-1">Your Name *</label>
                        <input type="text" name="client_name" value="{{ old('client_name') }}" class="field-brand @error('client_name') field-brand-error @enderror" required>
                        @error('client_name')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-navy mb-1">Email *</label>
                        <input type="email" name="client_email" value="{{ old('client_email') }}" class="field-brand @error('client_email') field-brand-error @enderror" required>
                        @error('client_email')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-navy mb-1">Phone</label>
                        <input type="text" name="client_phone" value="{{ old('client_phone') }}" class="field-brand">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-navy mb-1">Preferred Date</label>
                        <input type="date" name="preferred_date" value="{{ old('preferred_date') }}" class="field-brand" min="{{ date('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-navy mb-1">Origin (Pickup) *</label>
                        <input type="text" name="origin" value="{{ old('origin') }}" class="field-brand @error('origin') field-brand-error @enderror" placeholder="City or address" required>
                        @error('origin')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-navy mb-1">Destination (Delivery) *</label>
                        <input type="text" name="destination" value="{{ old('destination') }}" class="field-brand @error('destination') field-brand-error @enderror" placeholder="City or address" required>
                        @error('destination')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-navy mb-1">Estimated Weight (kg)</label>
                        <input type="number" name="weight_kg" value="{{ old('weight_kg') }}" class="field-brand" min="0" placeholder="e.g. 500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-navy mb-1">Cargo Description *</label>
                    <textarea name="cargo_description" class="field-brand @error('cargo_description') field-brand-error @enderror" rows="3" placeholder="What are you shipping? Include any special handling requirements." required>{{ old('cargo_description') }}</textarea>
                    @error('cargo_description')<p class="text-red-600 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="flex gap-3">
                    <button type="submit" class="btn-brand-primary">Submit Quote Request</button>
                    <a href="{{ url('/') }}" class="btn-brand-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
