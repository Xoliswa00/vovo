<x-app-layout>
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Add Service</h1>

        <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block font-bold">Title</label>
                <input type="text" name="title" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block font-bold">Description</label>
                <textarea name="description" rows="4" class="w-full border rounded p-2" required></textarea>
            </div>

            <div>
                <label class="block font-bold">Image</label>
                <input type="file" name="images[]" multiple class="w-full border rounded p-2">
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Save</button>
        </form>
    </div>
</x-app-layout>
