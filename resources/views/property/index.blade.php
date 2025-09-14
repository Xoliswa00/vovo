{{-- resources/views/listings/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Properties') }}
        </h2>
    </x-slot>
    <div class="py-12">

        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

            {{-- Flash success message --}}
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 text-green-800 rounded-lg shadow">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ADMIN VIEW --}}
            <div class="bg-white shadow rounded-lg p-6 mb-12">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl font-semibold text-gray-800">Manage Listings</h1>
                    <a href="{{ route('property.create') }}" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-md shadow hover:bg-blue-700">
                        + New Listing
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">#</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Title</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Price</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Location</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Type</th>
                                <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Status</th>
                                <th class="px-4 py-2 text-sm font-semibold text-gray-600">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse($properties as $listing)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 text-sm font-medium text-gray-900">{{ $listing->title }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">R {{ number_format($listing->price, 2) }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ $listing->city }}, {{ $listing->province }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-700">{{ ucfirst($listing->property_type) }}</td>
                                    <td class="px-4 py-2 text-sm">
                                        <span class="px-2 py-1 text-xs font-semibold rounded text-white 
                                            {{ strtolower($listing->status) == 'available' ? 'bg-green-500' : 'bg-red-500' }}">
                                            {{ ucfirst($listing->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 flex space-x-3">
                                        <a href="{{ route('property.show', $listing) }}" 
                                        class="text-blue-600 hover:underline">View</a>
                                        <a href="{{ route('property.edit', $listing) }}" 
                                        class="text-yellow-600 hover:underline">Edit</a>
                                        <form action="{{ route('property.destroy', $listing) }}" method="POST" 
                                            onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">
                                        No listings available. 
                                        <a href="{{ route('property.create') }}" class="text-blue-600 hover:underline">
                                            Create one
                                        </a>.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        {{-- FEATURED PROPERTY CARDS --}}
        <div class="container py-12" data-aos="fade-up" data-aos-delay="100">
            <div class="row g-4" data-aos="zoom-in" data-aos-delay="150">

                @forelse($properties as $property)
                    <div class="col-md-6 col-lg-4">
                        <article class="card shadow-sm rounded h-100 overflow-hidden">

                            {{-- Image / Fallback --}}
                            <a href="{{ route('property.show', $property->id) }}" class="d-block">
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

                            {{-- Content --}}
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="mb-1">
                                            <a href="{{ route('property.show', $property->id) }}" class="text-dark text-decoration-none">
                                                {{ $property->title }}
                                            </a>
                                        </h5>
                                        <div class="text-muted small">
                                            <i class="bi bi-geo-alt-fill me-1"></i> {{ $property->city }}, {{ $property->province }}
                                        </div>
                                    </div>
                                    <div class="fw-bold text-primary">R{{ number_format($property->price, 2) }}</div>
                                </div>

                                {{-- Quick Specs --}}
                                <div class="text-muted small mb-2">
                                    <span><i class="bi bi-door-open me-1"></i> {{ $property->bedrooms ?? '—' }} Beds</span> •
                                    <span><i class="bi bi-droplet me-1"></i> {{ $property->bathrooms ?? '—' }} Baths</span> •
                                    <span><i class="bi bi-aspect-ratio me-1"></i> {{ number_format(rand(1500,5000)) }} sq ft</span>
                                </div>

                                {{-- Short Description --}}
                                <p class="text-truncate-3 small flex-grow-1">
                                    {{ Str::limit($property->description, 120) }}
                                </p>

                                {{-- CTA + Meta --}}
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <a href="{{ route('property.show', $property->id) }}" class="btn btn-sm btn-primary">
                                        View Details
                                    </a>
                                    <div class="text-muted small text-end">
                                        <span class="badge bg-{{ strtolower($property->status) == 'available' ? 'success' : 'danger' }}">
                                            {{ ucfirst($property->status) }}
                                        </span><br>
                                        Listed {{ $property->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-5">
                        No properties available at the moment.
                    </div>
                @endforelse

            </div>

            {{-- Pagination --}}
            <div class="mt-5">
                {{ $properties->links() }}
            </div>
        </div>


        </div>
    </div>
</x-app-layout>
