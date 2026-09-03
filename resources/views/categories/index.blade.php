<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Categories</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4 flex justify-end">
                <a href="{{ route('categories.create') }}" class="px-4 py-2 bg-gray-700 text-white rounded-md text-sm hover:bg-gray-800">+ Add Category</a>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left">Name</th>
                            <th class="px-6 py-3 text-left">Type</th>
                            <th class="px-6 py-3 text-left">Services</th>
                            <th class="px-6 py-3 text-left">Products</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($categories as $category)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">
                                <p class="font-medium">{{ $category->name }}</p>
                                @if($category->icon)<span class="text-xs text-gray-400">{{ $category->icon }}</span>@endif
                            </td>
                            <td class="px-6 py-3 capitalize">{{ $category->type }}</td>
                            <td class="px-6 py-3">{{ $category->services_count }}</td>
                            <td class="px-6 py-3">{{ $category->products_count }}</td>
                            <td class="px-6 py-3 flex gap-2">
                                <a href="{{ route('categories.edit', $category) }}" class="text-gray-600 hover:underline text-xs">Edit</a>
                                <button type="button" class="text-red-500 hover:underline text-xs"
                                    @click="$dispatch('open-confirm', { message: 'Delete category &quot;{{ addslashes($category->name) }}&quot;?', action: '{{ route('categories.destroy', $category) }}' })">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-gray-400">No categories yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $categories->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
