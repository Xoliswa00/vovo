<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800">Quote #{{ $quoteRequest->id }}</h2>
            <a href="{{ route('quote-requests.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md text-sm">Back</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Client & Route --}}
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">Client Details</h3>
                    <div class="space-y-2 text-sm">
                        <div><span class="text-gray-500">Name:</span> <span class="font-medium">{{ $quoteRequest->client_name }}</span></div>
                        <div><span class="text-gray-500">Email:</span> <a href="mailto:{{ $quoteRequest->client_email }}" class="text-blue-600">{{ $quoteRequest->client_email }}</a></div>
                        <div><span class="text-gray-500">Phone:</span> {{ $quoteRequest->client_phone ?? '—' }}</div>
                        <div><span class="text-gray-500">Preferred Date:</span> {{ $quoteRequest->preferred_date?->format('d M Y') ?? '—' }}</div>
                        <div class="pt-2 border-t"><span class="text-gray-500">Origin:</span> <span class="font-medium">{{ $quoteRequest->origin }}</span></div>
                        <div><span class="text-gray-500">Destination:</span> <span class="font-medium">{{ $quoteRequest->destination }}</span></div>
                        <div><span class="text-gray-500">Weight:</span> {{ $quoteRequest->weight_kg ? number_format($quoteRequest->weight_kg).' kg' : '—' }}</div>
                        <div class="pt-2 border-t"><span class="text-gray-500">Cargo:</span><p class="mt-1">{{ $quoteRequest->cargo_description }}</p></div>
                    </div>
                </div>

                {{-- Update Status --}}
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="font-semibold text-gray-800 mb-4">
                        Update Quote
                        <span class="ml-2 text-xs px-2 py-1 rounded-full {{ $quoteRequest->status_badge }}">{{ ucfirst($quoteRequest->status) }}</span>
                    </h3>
                    <form method="POST" action="{{ route('quote-requests.update', $quoteRequest) }}">
                        @csrf @method('PATCH')
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" class="mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                    @foreach(['pending','quoted','accepted','rejected'] as $s)
                                        <option value="{{ $s }}" {{ $quoteRequest->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Quoted Price (R)</label>
                                <input type="number" name="quoted_price" step="0.01" value="{{ old('quoted_price', $quoteRequest->quoted_price) }}" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="0.00">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Admin Notes</label>
                                <textarea name="admin_notes" rows="4" class="mt-1 w-full border-gray-300 rounded-md shadow-sm" placeholder="Internal notes or message to client...">{{ old('admin_notes', $quoteRequest->admin_notes) }}</textarea>
                            </div>
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Update Quote</button>
                        </div>
                    </form>

                    <button type="button"
                        class="w-full mt-4 px-4 py-2 bg-red-100 text-red-700 rounded-md hover:bg-red-200 text-sm"
                        @click="$dispatch('open-confirm', { message: 'Delete this quote request from {{ addslashes($quoteRequest->client_name) }}?', action: '{{ route('quote-requests.destroy', $quoteRequest) }}' })">
                        Delete Quote Request
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
