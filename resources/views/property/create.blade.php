<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ isset($property) ? 'Edit Property' : 'Add Property' }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow sm:rounded-lg p-6">
            <form action="{{ isset($property) ? route('property.update', $property->id) : route('property.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($property))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 gap-6">

                    {{-- Title --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Title</label>
                        <input type="text" name="title" value="{{ old('title', $property->title ?? '') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-gray-200" required>
                        @error('title') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Price --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Price</label>
                        <input type="number" name="price" step="0.01" value="{{ old('price', $property->price ?? '') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200" required>
                        @error('price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Address Fields --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Street Address</label>
                            <input type="text" name="address" value="{{ old('address', $property->address ?? '') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200" required>
                            @error('address') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">City</label>
                            <input type="text" name="city" value="{{ old('city', $property->city ?? '') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200" required>
                            @error('city') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">State</label>
                            <input type="text" name="state" value="{{ old('state', $property->state ?? '') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200">
                            @error('state') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Country</label>
                            <input type="text" name="country" value="{{ old('country', $property->country ?? 'South Africa') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200">
                            @error('country') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Bedrooms, Bathrooms, Garage, Parking --}}
                    <div class="grid grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Bedrooms</label>
                            <input type="number" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms ?? 0) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200">
                            @error('bedrooms') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Bathrooms</label>
                            <input type="number" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms ?? 0) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200">
                            @error('bathrooms') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Garage</label>
                            <input type="number" name="garage" value="{{ old('garage', $property->garage ?? 0) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200">
                            @error('garage') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Parking Spaces</label>
                            <input type="number" name="parking_spaces" value="{{ old('parking_spaces', $property->parking_spaces ?? 0) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200">
                            @error('parking_spaces') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Size --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Size (sqm)</label>
                        <input type="number" name="size" value="{{ old('size', $property->size ?? '') }}"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200">
                        @error('size') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Property Type --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Property Type</label>
                        <select name="property_type"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200">
                            <option value="house" {{ old('property_type', $property->property_type ?? '') === 'house' ? 'selected' : '' }}>House</option>
                            <option value="apartment" {{ old('property_type', $property->property_type ?? '') === 'apartment' ? 'selected' : '' }}>Apartment</option>
                            <option value="commercial" {{ old('property_type', $property->property_type ?? '') === 'commercial' ? 'selected' : '' }}>Commercial</option>
                        </select>
                        @error('property_type') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Status --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Status</label>
                        <select name="status"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200">
                            <option value="Available" {{ old('status', $property->status ?? '') === 'Available' ? 'selected' : '' }}>Available</option>
                            <option value="Sold" {{ old('status', $property->status ?? '') === 'Sold' ? 'selected' : '' }}>Sold</option>
                            <option value="Rented" {{ old('status', $property->status ?? '') === 'Rented' ? 'selected' : '' }}>Rented</option>
                        </select>
                        @error('status') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Description</label>
                        <textarea name="description" rows="4"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm dark:bg-gray-700 dark:text-gray-200">{{ old('description', $property->description ?? '') }}</textarea>
                        @error('description') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Images --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Upload Images</label>
                        <input type="file" name="images[]" multiple
                               class="mt-1 block w-full text-gray-700 dark:text-gray-200">
                        @error('images') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                        @error('images.*') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror

                        @if(isset($property) && $property->images)
                            <div class="mt-2 flex flex-wrap gap-2">
                                @foreach($property->images as $img)
                                    <img src="{{ asset('storage/'.$img->filename) }}"
                                         class="w-20 h-20 object-cover rounded"
                                         alt="Property Image">
                                @endforeach
                            </div>
                        @endif
                    </div>

                    {{-- Submit --}}
                    <div>
                        <button type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                            {{ isset($property) ? 'Update Property' : 'Add Property' }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
