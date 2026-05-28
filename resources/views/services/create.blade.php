<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ isset($service) ? 'Edit Service' : 'Add Service' }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ isset($service) ? route('services.update', $service) : route('services.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if(isset($service)) @method('PATCH') @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Title *</label>
                            <input type="text" name="title" value="{{ old('title', $service->title ?? '') }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category</label>
                            <select name="category_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">— None —</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $service->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Vendor</label>
                            <select name="vendor_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">— None —</option>
                                @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" {{ old('vendor_id', $service->vendor_id ?? '') == $vendor->id ? 'selected' : '' }}>{{ $vendor->business_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Price (R)</label>
                            <input type="number" name="price" step="0.01" value="{{ old('price', $service->price ?? '') }}" min="0" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="Leave blank if quote-based">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="location" value="{{ old('location', $service->location ?? '') }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="e.g. Johannesburg">
                        </div>
                        <div class="flex items-center gap-3 pt-5">
                            <input type="hidden" name="status" value="0">
                            <input type="checkbox" name="status" id="status" value="1" {{ old('status', $service->status ?? true) ? 'checked' : '' }} class="rounded">
                            <label for="status" class="text-sm font-medium text-gray-700">Active (visible to public)</label>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" rows="4" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $service->description ?? '') }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Images</label>
                            <input type="file" name="images[]" multiple accept="image/*" class="mt-1 w-full border border-gray-300 rounded-md p-2">
                            <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP — max 2MB each</p>
                            @if(isset($service) && $service->images->count())
                                <div class="flex gap-2 mt-2 flex-wrap">
                                    @foreach($service->images as $img)
                                        <img src="{{ asset($img->image_path) }}" class="h-16 w-16 object-cover rounded border">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ isset($service) ? 'Update Service' : 'Create Service' }}
                        </button>
                        <a href="{{ route('services.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
