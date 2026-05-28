<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ isset($category) ? 'Edit Category' : 'Add Category' }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ isset($category) ? route('categories.update', $category) : route('categories.store') }}">
                    @csrf
                    @if(isset($category)) @method('PATCH') @endif

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Name *</label>
                            <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Type *</label>
                            <select name="type" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @foreach(['both','service','product'] as $t)
                                    <option value="{{ $t }}" {{ old('type', $category->type ?? 'both') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Icon (Bootstrap icon name)</label>
                            <input type="text" name="icon" value="{{ old('icon', $category->icon ?? '') }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="e.g. bi-truck">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" rows="3" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">{{ old('description', $category->description ?? '') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="px-6 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800">
                            {{ isset($category) ? 'Update' : 'Create Category' }}
                        </button>
                        <a href="{{ route('categories.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
