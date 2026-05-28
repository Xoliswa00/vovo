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
             src="{{ asset('assets/img/' . $property->images->first()->image_path) }}" 
             alt="Main Image" 
             class="w-full h-96 object-cover rounded-xl shadow-md">

        {{-- Thumbnails --}}
        <div class="flex gap-3 mt-4 overflow-x-auto">
            @foreach($property->images as $image)
                <img src="{{ asset('assets/img/' . $image->image_path) }}" 
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
    <a href="https://wa.me/27838819497?text=Hello, I’m interested in the property: {{ urlencode($property->title) }}"
       target="_blank"
       class="px-5 py-2 bg-green-600  rounded-lg hover:bg-green-700 shadow flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 .5C5.65.5.5 5.65.5 12c0 2.07.54 4.05 1.57 5.8L.5 23.5l5.85-1.54A11.4 11.4 0 0 0 12 23.5c6.35 0 11.5-5.15 11.5-11.5S18.35.5 12 .5Zm0 21a9.95 9.95 0 0 1-5.1-1.4l-.37-.22-3.47.91.93-3.39-.24-.35A9.93 9.93 0 1 1 12 21.5Zm5.55-7.9c-.3-.15-1.76-.87-2.03-.97-.27-.1-.47-.15-.67.15-.2.3-.77.96-.95 1.16-.18.2-.35.23-.65.08-.3-.15-1.28-.47-2.44-1.5-.9-.8-1.5-1.78-1.67-2.08-.18-.3-.02-.46.13-.61.13-.13.3-.35.45-.53.15-.18.2-.3.3-.5.1-.2.05-.38-.02-.53-.07-.15-.67-1.62-.92-2.2-.24-.57-.48-.5-.67-.51h-.57c-.2 0-.53.08-.8.38-.27.3-1.05 1.03-1.05 2.5s1.08 2.9 1.23 3.1c.15.2 2.13 3.25 5.15 4.55.72.31 1.28.5 1.72.64.72.23 1.38.2 1.9.12.58-.09 1.76-.72 2.01-1.42.25-.7.25-1.3.18-1.42-.07-.12-.27-.2-.57-.35Z"/>
        </svg>
        WhatsApp Agent
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
