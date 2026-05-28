<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">{{ $vendor->business_name }}</h2>
            <a href="{{ route('vendors.edit', $vendor) }}" class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm">Edit</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow rounded-lg p-6">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                    <div><p class="text-gray-500 text-xs">Phone</p><p class="font-medium">{{ $vendor->phone ?? '—' }}</p></div>
                    <div><p class="text-gray-500 text-xs">Address</p><p class="font-medium">{{ $vendor->address ?? '—' }}</p></div>
                    <div><p class="text-gray-500 text-xs">Status</p><span class="text-xs px-2 py-1 rounded-full {{ $vendor->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">{{ ucfirst($vendor->status) }}</span></div>
                    <div><p class="text-gray-500 text-xs">Member Since</p><p class="font-medium">{{ $vendor->created_at->format('M Y') }}</p></div>
                </div>
                @if($vendor->description)<p class="mt-4 text-sm text-gray-600">{{ $vendor->description }}</p>@endif
            </div>

            @if($vendor->services->count())
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Services ({{ $vendor->services->count() }})</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($vendor->services as $service)
                    <div class="border rounded-lg p-3 text-sm">
                        <p class="font-medium">{{ $service->title }}</p>
                        <p class="text-gray-500">{{ Str::limit($service->description, 60) }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            @if($vendor->products->count())
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Products ({{ $vendor->products->count() }})</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($vendor->products as $product)
                    <div class="border rounded-lg overflow-hidden">
                        @if($product->images->count())
                            <img src="{{ asset($product->images->first()->image_path) }}" class="w-full h-24 object-cover">
                        @endif
                        <div class="p-2 text-sm">
                            <p class="font-medium truncate">{{ $product->title }}</p>
                            <p class="text-primary font-bold">R {{ number_format($product->price,2) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
