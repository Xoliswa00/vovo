<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">{{ $service->title }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow rounded-lg px-4 py-3 flex flex-wrap items-center justify-between gap-3">
                <a href="{{ route('services.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-700">&larr; Back to Services</a>
                <a href="{{ route('services.edit', $service) }}" class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">Edit</a>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm mb-4">
                    <div><p class="text-gray-500 text-xs">Category</p><p class="font-medium">{{ $service->category->name ?? '—' }}</p></div>
                    <div><p class="text-gray-500 text-xs">Vendor</p><p class="font-medium">{{ $service->vendor->business_name ?? '—' }}</p></div>
                    <div><p class="text-gray-500 text-xs">Price</p><p class="font-medium">{{ $service->price ? 'R '.number_format($service->price,2) : 'Quote-based' }}</p></div>
                    <div><p class="text-gray-500 text-xs">Status</p><span class="text-xs px-2 py-1 rounded-full {{ $service->status ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">{{ $service->status ? 'Active' : 'Inactive' }}</span></div>
                </div>
                @if($service->description)<p class="text-gray-600">{{ $service->description }}</p>@endif

                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-700 mb-1">Photos</p>
                    <x-services.image-manager :service="$service" />

                    <form method="POST" action="{{ route('services.images.store', $service) }}" enctype="multipart/form-data" class="mt-3 max-w-sm">
                        @csrf
                        <x-services.image-dropzone />
                        <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700">Upload Photos</button>
                    </form>
                </div>
            </div>

            {{-- Reviews --}}
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="px-6 py-4 border-b font-semibold text-gray-800">Reviews ({{ $service->reviews->count() }})</div>
                <div class="divide-y">
                    @forelse($service->reviews as $review)
                    <div class="px-6 py-3">
                        <div class="flex justify-between">
                            <p class="font-medium text-sm">{{ $review->reviewer_name }}</p>
                            <span class="text-yellow-500 text-sm">{{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5-$review->rating) }}</span>
                        </div>
                        @if($review->comment)<p class="text-sm text-gray-500 mt-1">{{ $review->comment }}</p>@endif
                    </div>
                    @empty
                    <div class="px-6 py-4 text-gray-400 text-sm">No reviews yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
