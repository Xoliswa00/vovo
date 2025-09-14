<x-guest-layout>
    <div class="max-w-6xl mx-auto p-6">
        {{-- Title + Back --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">{{ $property->title }}</h1>
            <a href="{{ route('welcome') }}" class="text-blue-600 hover:underline">← Back to Listings</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            {{-- Images Section --}}
            <div>
                @if($property->images->count() > 0)
                    {{-- Main Image --}}
                    <img id="main-image" 
                         src="{{ asset('storage/'.$property->images->first()->image_path) }}" 
                         alt="Main Image" 
                         class="w-full h-96 object-cover rounded-xl shadow-md">

                    {{-- Thumbnails --}}
                    <div class="flex gap-3 mt-4 overflow-x-auto">
                        @foreach($property->images as $image)
                            <img src="{{ asset('storage/'.$image->image_path) }}" 
                                 alt="Thumbnail"
                                 class="w-20 h-20 object-cover rounded-lg border border-gray-300 hover:border-blue-500 cursor-pointer thumbnail">
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No images uploaded for this property.</p>
                @endif
            </div>

            {{-- Property Details --}}
            <div>
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Property Details</h2>

                <p class="mb-2"><strong>Price:</strong> R{{ number_format($property->price, 2) }}</p>
                <p class="mb-2"><strong>Location:</strong> {{ $property->location }}</p>
                <p class="mb-2"><strong>Bedrooms:</strong> {{ $property->bedrooms }}</p>
                <p class="mb-2"><strong>Bathrooms:</strong> {{ $property->bathrooms }}</p>
                <p class="mb-2"><strong>Size:</strong> {{ $property->size }} m²</p>

                <div class="mt-4">
                    <h3 class="text-lg font-semibold text-gray-600">Description</h3>
                    <p class="text-gray-700 mt-2">{{ $property->description }}</p>
                </div>

                {{-- Contact Button --}}
                <div class="mt-6">
                    <a href="mailto:info@example.com" 
                       class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow">
                        Contact Agent
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Thumbnail click JS --}}
    <script>
        document.querySelectorAll('.thumbnail').forEach(img => {
            img.addEventListener('click', function() {
                document.getElementById('main-image').src = this.src;
            });
        });
    </script>
</x-guest-layout>
