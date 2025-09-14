{{-- resources/views/listings/index.blade.php --}}
<x-guest-layout>
    <section class="py-5 container">
        <div class="py-4">

            {{-- Flash success message --}}
            @if(session('success'))
                <div class="mb-4 p-3 bg-success bg-opacity-10 text-success rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Page Heading --}}
            <div class="text-center mb-5">
                <h2 class="fw-bold">Available Properties</h2>
                <p class="text-muted">Browse through our latest property listings.</p>
            </div>

            {{-- Filters --}}
            <div class="row mb-4 g-3">
                <div class="col-md-3">
                    <input type="text" id="searchFilter" class="form-control" placeholder="Search by title...">
                </div>
                <div class="col-md-3">
                    <select id="cityFilter" class="form-select">
                        <option value="">All Cities</option>
                        @foreach($properties->pluck('city')->unique() as $city)
                            <option value="{{ strtolower($city) }}">{{ $city }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="bedroomFilter" class="form-select">
                        <option value="">Any Bedrooms</option>
                        <option value="1">1+</option>
                        <option value="2">2+</option>
                        <option value="3">3+</option>
                        <option value="4">4+</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select id="statusFilter" class="form-select">
                        <option value="">Any Status</option>
                        <option value="available">Available</option>
                        <option value="sold">Sold</option>
                        <option value="rented">Rented</option>
                    </select>
                </div>
            </div>

            {{-- Properties Grid --}}
            <div class="row g-4" id="propertyGrid">
                @forelse($properties as $property)
                    <div class="col-md-6 col-lg-4 property-card"
                        data-title="{{ strtolower($property->title) }}"
                        data-city="{{ strtolower($property->city) }}"
                        data-bedrooms="{{ $property->bedrooms }}"
                        data-status="{{ strtolower($property->status) }}"
                        data-price="{{ $property->price }}">
                        
                        <article class="card shadow-sm h-100 border-0">
                            {{-- Image --}}
                            <a href="{{ route('Guest.show', $property->id) }}" class="d-block">
                                @if($property->images->count())
                                    <img src="{{ asset('storage/'.$property->images->first()->image_path) }}"
                                        alt="{{ $property->title }}"
                                        class="img-fluid w-100"
                                        style="height: 220px; object-fit: cover;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                         style="height: 220px;">
                                        <span class="text-muted">No Image Available</span>
                                    </div>
                                @endif
                            </a>

                            {{-- Card Body --}}
                            <div class="p-3 d-flex flex-column">
                                <div class="d-flex justify-content-between mb-2">
                                    <h5 class="mb-0">
                                        <a href="{{ route('Guest.show', $property->id) }}" 
                                           class="text-dark text-decoration-none">
                                           {{ $property->title }}
                                        </a>
                                    </h5>
                                    <span class="fw-bold text-primary">
                                        R{{ number_format($property->price, 2) }}
                                    </span>
                                </div>

                                <div class="text-muted small mb-2">
                                    <i class="bi bi-geo-alt-fill me-1"></i> {{ $property->city }}, {{ $property->province }}
                                </div>

                                {{-- Specs --}}
                                <div class="text-muted small mb-2">
                                    <span><i class="bi bi-door-open me-1"></i> {{ $property->bedrooms ?? '—' }} Beds</span> •
                                    <span><i class="bi bi-droplet me-1"></i> {{ $property->bathrooms ?? '—' }} Baths</span>
                                </div>

                                {{-- Description --}}
                                <p class="small text-truncate" style="max-height: 48px; overflow: hidden;">
                                    {{ Str::limit($property->description, 100) }}
                                </p>

                                {{-- Footer --}}
                                <div class="d-flex justify-content-between align-items-center mt-auto">
                                    <a href="{{ route('Guest.show', $property->id) }}" class="btn btn-sm btn-primary">
                                        View Details
                                    </a>
                                    <span class="badge bg-{{ strtolower($property->status) == 'available' ? 'success' : 'danger' }}">
                                        {{ ucfirst($property->status) }}
                                    </span>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No properties found at the moment.</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            <div class="mt-5 d-flex justify-content-center">
                {{ $properties->links() }}
            </div>
        </div>
    </section>

    {{-- JS Filter --}}
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const cards = document.querySelectorAll(".property-card");
            const searchFilter = document.getElementById("searchFilter");
            const cityFilter = document.getElementById("cityFilter");
            const bedroomFilter = document.getElementById("bedroomFilter");
            const statusFilter = document.getElementById("statusFilter");

            function applyFilters() {
                const search = searchFilter.value.toLowerCase();
                const city = cityFilter.value;
                const bedrooms = bedroomFilter.value;
                const status = statusFilter.value;

                cards.forEach(card => {
                    const title = card.dataset.title;
                    const cardCity = card.dataset.city;
                    const cardBedrooms = parseInt(card.dataset.bedrooms || 0);
                    const cardStatus = card.dataset.status;

                    let show = true;

                    if (search && !title.includes(search)) show = false;
                    if (city && cardCity !== city) show = false;
                    if (bedrooms && cardBedrooms < parseInt(bedrooms)) show = false;
                    if (status && cardStatus !== status) show = false;

                    card.style.display = show ? "block" : "none";
                });
            }

            [searchFilter, cityFilter, bedroomFilter, statusFilter].forEach(el => {
                el.addEventListener("input", applyFilters);
                el.addEventListener("change", applyFilters);
            });
        });
    </script>
</x-guest-layout>
