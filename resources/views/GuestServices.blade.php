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
                          {{-- Main Image --}}
@if($service->images->count())
    <img id="main-image" 
         src="{{ asset($service->images->first()->image_path) }}" 
         alt="Main Image" 
         class="w-full h-96 object-cover rounded-xl shadow-md">

    {{-- Thumbnails --}}
    <div class="flex gap-3 mt-4 overflow-x-auto">
        @foreach($service->images as $image)
            <img src="{{ asset($image->image_path) }}" 
                 alt="Thumbnail"
                 class="w-20 h-20 object-cover rounded-lg border border-gray-300 hover:border-blue-500 cursor-pointer thumbnail">
        @endforeach
    </div>
@else
    <p class="text-gray-500">No images uploaded.</p>
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
                                {{ Str::limit($service->description, 500) }}
                            </p>

                            <!-- CTA + Meta -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <div class="mt-6">
    <a href="https://wa.me/27838819497?text=Hello, I’m interested in the property: {{ urlencode($service->title) }}"
       target="_blank"
       class="px-5 py-2 bg-green-600  rounded-lg hover:bg-green-700 shadow flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 .5C5.65.5.5 5.65.5 12c0 2.07.54 4.05 1.57 5.8L.5 23.5l5.85-1.54A11.4 11.4 0 0 0 12 23.5c6.35 0 11.5-5.15 11.5-11.5S18.35.5 12 .5Zm0 21a9.95 9.95 0 0 1-5.1-1.4l-.37-.22-3.47.91.93-3.39-.24-.35A9.93 9.93 0 1 1 12 21.5Zm5.55-7.9c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.96-.95 1.16-.18.2-.35.23-.65.08-.3-.15-1.28-.47-2.44-1.5-.9-.8-1.5-1.78-1.67-2.08-.18-.3-.02-.46.13-.61.13-.13.3-.35.45-.53.15-.18.2-.3.3-.5.1-.2.05-.38-.02-.53-.07-.15-.67-1.62-.92-2.2-.24-.57-.48-.5-.67-.51h-.57c-.2 0-.53.08-.8.38-.27.3-1.05 1.03-1.05 2.5s1.08 2.9 1.23 3.1c.15.2 2.13 3.25 5.15 4.55.72.31 1.28.5 1.72.64.72.23 1.38.2 1.9.12.58-.09 1.76-.72 2.01-1.42.25-.7.25-1.3.18-1.42-.07-.12-.27-.2-.57-.35Z"/>
        </svg>
        WhatsApp Agent
    </a>
</div>
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
