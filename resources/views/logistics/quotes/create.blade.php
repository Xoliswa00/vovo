@extends('layouts.public')

@section('title', 'Request a Logistics Quote — Nobela Enterprises')

@section('content')
<section class="py-5 bg-light">
    <div class="container" style="max-width: 700px">
        <div class="text-center mb-4" data-aos="fade-up">
            <h2 class="fw-bold">Get a Logistics Quote</h2>
            <p class="text-muted">Tell us about your shipment and we'll get back to you with a competitive price.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card shadow-sm border-0" data-aos="fade-up" data-aos-delay="100">
            <div class="card-body p-4">
                <form method="POST" action="{{ route('quote.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Your Name *</label>
                            <input type="text" name="client_name" value="{{ old('client_name') }}" class="form-control @error('client_name') is-invalid @enderror" required>
                            @error('client_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email *</label>
                            <input type="email" name="client_email" value="{{ old('client_email') }}" class="form-control @error('client_email') is-invalid @enderror" required>
                            @error('client_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="client_phone" value="{{ old('client_phone') }}" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Preferred Date</label>
                            <input type="date" name="preferred_date" value="{{ old('preferred_date') }}" class="form-control" min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Origin (Pickup) *</label>
                            <input type="text" name="origin" value="{{ old('origin') }}" class="form-control @error('origin') is-invalid @enderror" placeholder="City or address" required>
                            @error('origin')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Destination (Delivery) *</label>
                            <input type="text" name="destination" value="{{ old('destination') }}" class="form-control @error('destination') is-invalid @enderror" placeholder="City or address" required>
                            @error('destination')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Estimated Weight (kg)</label>
                            <input type="number" name="weight_kg" value="{{ old('weight_kg') }}" class="form-control" min="0" placeholder="e.g. 500">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Cargo Description *</label>
                            <textarea name="cargo_description" class="form-control @error('cargo_description') is-invalid @enderror" rows="3" placeholder="What are you shipping? Include any special handling requirements." required>{{ old('cargo_description') }}</textarea>
                            @error('cargo_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary px-5">Submit Quote Request</button>
                            <a href="{{ url('/') }}" class="btn btn-outline-secondary ms-2">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
