{{-- resources/views/services/index.blade.php --}}
<x-app-layout>
     <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Services') }}
        </h2>
    </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-6">
                {{-- Flash success message --}}
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg shadow">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white shadow rounded-lg p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-2xl font-semibold text-gray-800">Available Services</h1>
                        <a href="{{ route('services.create') }}" 
                        class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700">
                            + New Service
                        </a>
                    </div>
                    <p class="text-gray-600">Browse and manage the services offered on the platform.</p>
                </div>
            </div>

            <div class="container py-12" data-aos="fade-up" data-aos-delay="100">
                 <div class="row g-4" data-aos="zoom-in" data-aos-delay="150">

                    @forelse($services as $service)
                    <div class="col-md-6 col-lg-4">
                        <article class="card shadow-sm rounded h-100 overflow-hidden">
                            <a href="{{ route('services.show', $service->id) }}">
                                @if($service->images->count())
                                    <img src="{{ asset('storage/'.$service->images->first()->image_path) }}" 
                                         class="card-img-top" alt="{{ $service->title }}">
                                @else
                                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400">
                                        No Image Available
                                    </div>
                                @endif
                            </a>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">
                                    <a href="{{ route('services.show', $service->id) }}" class="text-decoration-none text-dark">
                                        {{ $service->title }}
                                    </a>
                                </h5>
                                <p class="card-text text-muted flex-grow-1">
                                    {{ Str::limit($service->description, 100) }}    
                                </p>
                                <div class="mt-3 d-flex justify-content-between align-items-center">
                                    <a href="{{ route('services.request', $service->id) }}" 
                                       class="btn btn-primary btn-sm">
                                        Request Service
                                    </a>
                                    <span class="text-muted text-sm">
                                        Added {{ $service->created_at->diffForHumans() }}   
                                    </span>
                                </div>
                            </div>
                        </article>
                    </div> 
                    @empty
                        <div class="col-12 text-center py-10 text-gray-500">
                            No services available at the moment.
                        </div>
                    @endforelse
                 </div> 
                         <!-- Pagination -->
                <div class="mt-6">
                    {{ $services->links() }}
                </div>

            </div>
        </div>



</x-app-layout>
