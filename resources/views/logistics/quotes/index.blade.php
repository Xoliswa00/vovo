<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Quote Requests</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif

            {{-- Filters --}}
            <div class="mb-4 flex gap-2">
                @foreach(['', 'pending', 'quoted', 'accepted', 'rejected'] as $s)
                <a href="{{ route('quote-requests.index', $s ? ['status'=>$s] : []) }}"
                   class="px-3 py-1 rounded-full text-sm {{ $status === $s || ($s === '' && !$status) ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-700' }}">
                    {{ $s ? ucfirst($s) : 'All' }}
                </a>
                @endforeach
            </div>

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left">#</th>
                            <th class="px-6 py-3 text-left">Client</th>
                            <th class="px-6 py-3 text-left">Route</th>
                            <th class="px-6 py-3 text-left">Date</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Quoted Price</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($quotes as $quote)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 text-gray-400">{{ $quote->id }}</td>
                            <td class="px-6 py-3">
                                <p class="font-medium">{{ $quote->client_name }}</p>
                                <p class="text-gray-500 text-xs">{{ $quote->client_email }}</p>
                            </td>
                            <td class="px-6 py-3">{{ $quote->origin }} → {{ $quote->destination }}</td>
                            <td class="px-6 py-3">{{ $quote->preferred_date?->format('d M Y') ?? '—' }}</td>
                            <td class="px-6 py-3"><span class="text-xs px-2 py-1 rounded-full {{ $quote->status_badge }}">{{ ucfirst($quote->status) }}</span></td>
                            <td class="px-6 py-3">{{ $quote->quoted_price ? 'R '.number_format($quote->quoted_price,2) : '—' }}</td>
                            <td class="px-6 py-3">
                                <a href="{{ route('quote-requests.show', $quote) }}" class="text-blue-600 hover:underline">Review</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-6 py-8 text-center text-gray-400">No quote requests yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $quotes->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
