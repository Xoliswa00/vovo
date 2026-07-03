<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ isset($product) ? 'Edit Product' : 'Add Product' }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ isset($product) ? route('products.update', $product) : route('products.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if(isset($product)) @method('PATCH') @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Title *</label>
                            <input type="text" name="title" value="{{ old('title', $product->title ?? '') }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Price (R) *</label>
                            <input type="number" name="price" step="0.01" value="{{ old('price', $product->price ?? '') }}" required min="0" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Stock *</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required min="0" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category</label>
                            <select name="category_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">— None —</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(auth()->user()->isAdmin())
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Vendor</label>
                            <select name="vendor_id" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">— None —</option>
                                @foreach($vendors as $vendor)
                                    <option value="{{ $vendor->id }}" {{ old('vendor_id', $product->vendor_id ?? '') == $vendor->id ? 'selected' : '' }}>{{ $vendor->business_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Vendor</label>
                            <p class="mt-1 text-sm text-gray-500 py-2">{{ auth()->user()->vendor?->business_name ?? 'Your vendor profile' }}</p>
                        </div>
                        @endif
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status *</label>
                            <select name="status" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="active" {{ old('status', $product->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $product->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" rows="4" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $product->description ?? '') }}</textarea>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Images</label>
                            <input type="file" name="images[]" multiple accept="image/*" class="mt-1 w-full border border-gray-300 rounded-md p-2">
                            <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP — max 3MB each</p>
                            @if(isset($product) && $product->images->count())
                                <div class="flex gap-2 mt-2 flex-wrap">
                                    @foreach($product->images as $img)
                                        <img src="{{ asset($img->image_path) }}" class="h-16 w-16 object-cover rounded border">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                            {{ isset($product) ? 'Update Product' : 'Add Product' }}
                        </button>
                        <a href="{{ route('products.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
