<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Our Work</h2>
            <a href="{{ route('projects.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm hover:bg-blue-700">+ New Project</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left">Project</th>
                            <th class="px-6 py-3 text-left">Category</th>
                            <th class="px-6 py-3 text-left">Completed</th>
                            <th class="px-6 py-3 text-center">Photos</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($projects as $project)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">
                                <p class="font-medium">{{ $project->title }}</p>
                                <p class="text-gray-500 text-xs">{{ Str::limit($project->summary ?: $project->description, 60) }}</p>
                            </td>
                            <td class="px-6 py-3 text-gray-500">{{ $project->category ?? '—' }}</td>
                            <td class="px-6 py-3 text-gray-500">{{ $project->completed_at?->format('M Y') ?? '—' }}</td>
                            <td class="px-6 py-3 text-center text-gray-500">{{ $project->images_count }}</td>
                            <td class="px-6 py-3">
                                <span class="text-xs px-2 py-1 rounded-full {{ $project->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $project->is_published ? 'Published' : 'Draft' }}
                                </span>
                                @if($project->is_featured)
                                    <span class="text-xs px-2 py-1 rounded-full bg-amber-100 text-amber-800">Featured</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 flex gap-2">
                                @if($project->is_published)
                                    <a href="{{ route('projects.show.public', $project) }}" target="_blank" class="text-blue-600 hover:underline text-xs">View</a>
                                @endif
                                <a href="{{ route('projects.edit', $project) }}" class="text-gray-600 hover:underline text-xs">Edit</a>
                                <button type="button" class="text-red-500 hover:underline text-xs"
                                    @click="$dispatch('open-confirm', { message: 'Delete project &quot;{{ addslashes($project->title) }}&quot;?', action: '{{ route('projects.destroy', $project) }}', method: 'DELETE' })">
                                    Del
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">No projects yet. Add your first fabrication project to the gallery.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $projects->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
