<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ isset($project) ? 'Edit Project' : 'Add Project' }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ isset($project) ? route('projects.update', $project) : route('projects.store') }}" enctype="multipart/form-data">
                    @csrf
                    @if(isset($project)) @method('PATCH') @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Title *</label>
                            <input type="text" name="title" value="{{ old('title', $project->title ?? '') }}" required class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Summary</label>
                            <input type="text" name="summary" value="{{ old('summary', $project->summary ?? '') }}" maxlength="255" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="One line shown on the gallery card">
                            @error('summary')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category</label>
                            <input type="text" name="category" value="{{ old('category', $project->category ?? '') }}" list="project-categories" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="e.g. Boilermaking">
                            <datalist id="project-categories">
                                <option value="Boilermaking"></option>
                                <option value="Structural Steel"></option>
                                <option value="Pressure Vessels"></option>
                                <option value="Piping &amp; Fabrication"></option>
                                <option value="Repairs &amp; Maintenance"></option>
                                <option value="Machinery"></option>
                            </datalist>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Materials</label>
                            <input type="text" name="materials" value="{{ old('materials', $project->materials ?? '') }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="e.g. Mild steel, 304 stainless">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Client</label>
                            <input type="text" name="client" value="{{ old('client', $project->client ?? '') }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="Optional">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" name="location" value="{{ old('location', $project->location ?? '') }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="e.g. Germiston">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Completed</label>
                            <input type="date" name="completed_at" value="{{ old('completed_at', isset($project) && $project->completed_at ? $project->completed_at->format('Y-m-d') : '') }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Sort order</label>
                            <input type="number" name="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}" min="0" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="Lower shows first">
                        </div>

                        <div class="flex items-center gap-3 pt-2">
                            <input type="hidden" name="is_published" value="0">
                            <input type="checkbox" name="is_published" id="is_published" value="1" {{ old('is_published', $project->is_published ?? false) ? 'checked' : '' }} class="rounded">
                            <label for="is_published" class="text-sm font-medium text-gray-700">Published. <span class="text-gray-500 font-normal">Tick once the photos and write-up are ready.</span></label>
                        </div>
                        <div class="flex items-center gap-3 pt-2">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $project->is_featured ?? false) ? 'checked' : '' }} class="rounded">
                            <label for="is_featured" class="text-sm font-medium text-gray-700">Feature on the home page</label>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea name="description" rows="5" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="What was designed and built, the challenge, the outcome...">{{ old('description', $project->description ?? '') }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Photos</label>

                            @if(isset($project) && $project->images->count())
                                <p class="text-xs text-gray-500 mt-1 mb-1">Existing photos — hover to set a cover or delete:</p>
                                <x-projects.image-manager :project="$project" />
                                <p class="text-xs text-gray-500 mt-3 mb-1">Add more:</p>
                            @endif

                            <x-services.image-dropzone />
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ isset($project) ? 'Update Project' : 'Create Project' }}
                        </button>
                        <a href="{{ route('projects.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
