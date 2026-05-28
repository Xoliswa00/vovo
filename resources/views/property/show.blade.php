{{-- resources/views/properties/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Property Details') }}
        </h2>   
    </x-slot>

    <div class="py-10 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            
            {{-- Title + Back --}}
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900">{{ $property->title }}</h1>
                <a href="{{ route('property.index') }}" 
                   class="text-sm text-blue-600 hover:text-blue-800">
                    ← Back to Listings
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                
           {{-- Images Section --}}
<div>
    @if($property->images->count() > 0)
        {{-- Main Image --}}
        <div class="w-full h-96 bg-gray-100 rounded-xl overflow-hidden shadow-md">
            <img id="mainImage" 
                src="{{ asset('storage/'.$property->images->first()->image_path) }}" 
                alt="Main Image" 
                class="w-full h-full object-cover cursor-pointer"
                onclick="openLightbox('{{ asset('storage/'.$property->images->first()->image_path) }}')">
        </div>

        {{-- Thumbnails --}}
        <div class="flex gap-3 mt-4 overflow-x-auto">
            @foreach($property->images as $image)
                <div class="w-24 h-24 bg-gray-100 rounded-lg overflow-hidden border border-gray-300 hover:border-blue-500 cursor-pointer">
                    <img src="{{ asset('storage/'.$image->image_path) }}" 
                        alt="Thumbnail"
                        class="w-full h-full object-cover"
                        onclick="changeMainImage(this)">
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">No images uploaded for this property.</p>
    @endif
</div>


                {{-- Property Details --}}
                <div class="bg-white p-6 rounded-xl shadow-sm">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Property Details</h2>

                    <div class="space-y-2 text-gray-700">
                        <p><strong class="font-medium">Price:</strong> 
                            <span class="text-green-600 font-bold">R{{ number_format($property->price, 2) }}</span>
                        </p>
                        <p><strong class="font-medium">Location:</strong> {{ $property->location }}</p>
                        <p><strong class="font-medium">Bedrooms:</strong> {{ $property->bedrooms }}</p>
                        <p><strong class="font-medium">Bathrooms:</strong> {{ $property->bathrooms }}</p>
                        <p><strong class="font-medium">Size:</strong> {{ $property->size }} m²</p>
                        <p>
                            <strong class="font-medium">Status:</strong> 
                            <span class="px-2 py-1 rounded text-white 
                                {{ strtolower($property->status) == 'available' ? 'bg-green-500' : 'bg-red-500' }}">
                                {{ ucfirst($property->status) }}
                            </span>
                        </p>
                    </div>

                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-700">Description</h3>
                        <p class="mt-2 text-gray-600 leading-relaxed">
                            {{ $property->description }}
                        </p>
                    </div>

                    {{-- Contact --}}
                    <div class="mt-8 flex gap-4">
                        <a href="mailto:info@example.com" 
                           class="px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow transition">
                            Contact Agent
                        </a>
                        <a href="tel:+27712345678" 
                           class="px-5 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 shadow transition">
                            Call Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Lightbox Modal --}}
    <div id="lightbox" class="fixed inset-0 hidden bg-black bg-opacity-80 items-center justify-center z-50">
        <span class="absolute top-5 right-8 text-white text-4xl cursor-pointer hover:scale-110 transition" 
              onclick="closeLightbox()">&times;</span>
        <img id="lightboxImage" src="" class="max-h-[90%] max-w-[90%] rounded-lg shadow-lg">
    </div>

    <script>
        function changeMainImage(thumbnail) {
            document.getElementById('mainImage').src = thumbnail.src;
            document.getElementById('mainImage').setAttribute("onclick", `openLightbox('${thumbnail.src}')`);
        }
        function openLightbox(src) {
            document.getElementById('lightbox').classList.remove('hidden');
            document.getElementById('lightboxImage').src = src;
        }
        function closeLightbox() {
            document.getElementById('lightbox').classList.add('hidden');
        }
    </script>
</x-app-layout>
