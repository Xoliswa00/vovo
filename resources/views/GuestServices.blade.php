<x-guest-layout>
    <!-- Hero / Intro -->
    <section class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white py-12 mb-8">
        <div class="container text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold mb-3">Our Logistics Services</h1>
            <p class="text-base md:text-lg opacity-90 max-w-2xl mx-auto">
                Explore the range of professional services we offer to streamline your operations 
                and help your business grow.
            </p>
        </div>
    </section>

    <!-- Services Grid -->
    <div class="container py-12" data-aos="fade-up" data-aos-delay="100">
        <div class="row g-4" data-aos="zoom-in" data-aos-delay="150">

            @forelse($services as $service)
                <div class="col-md-6 col-lg-4">
                    <article class="card shadow-sm border-0 rounded-lg h-100 overflow-hidden service-card">

                        <!-- Image -->
                        <a href="{{ route('services.show', $service->id) }}" class="d-block position-relative">
                            @if($service->images->count())
                                <img src="{{ asset('storage/'.$service->images->first()->image_path) }}" 
                                    class="card-img-top img-fluid"
                                    alt="{{ $service->title }}"
                                    style="height: 220px; object-fit: cover;">
                            @else
                                <div class="w-100 bg-light d-flex align-items-center justify-content-center text-muted" 
                                    style="height: 220px;">
                                    No Image Available
                                </div>
                            @endif
                            <span class="badge bg-primary position-absolute top-0 end-0 m-2">
                                Logistics
                            </span>
                        </a>

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-semibold mb-2">
                                <a href="{{ route('services.show', $service->id) }}" 
                                    {{ $service->title }}
                                </a>
                            </h5>

                            <!-- Short Description -->
                            <p class="card-text text-muted small flex-grow-1">
                                {{ Str::limit($service->description, 100) }}
                            </p>

                            <!-- CTA + Meta -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="{{ route('services.request', $service->id) }}" 
                                   class="btn btn-sm btn-outline-primary">
                                    Request Service
                                </a>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i> {{ $service->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                    </article>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">
                    No services available at the moment.
                </div>
            @endforelse

        </div>

        <!-- Pagination -->
        <div class="mt-5">
            {{ $services->links() }}
        </div>
    </div>

    <!-- Optional Custom CSS -->
    <style>
        .service-card {
            transition: transform .2s ease, box-shadow .2s ease;
        }
        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
    </style>
</x-guest-layout>
