<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Reviews</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-xs text-gray-500 uppercase">
                        <tr>
                            <th class="px-6 py-3 text-left">Reviewer</th>
                            <th class="px-6 py-3 text-left">For</th>
                            <th class="px-6 py-3 text-left">Rating</th>
                            <th class="px-6 py-3 text-left">Comment</th>
                            <th class="px-6 py-3 text-left">Date</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @forelse($reviews as $review)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3">
                                <p class="font-medium">{{ $review->reviewer_name }}</p>
                                <p class="text-gray-500 text-xs">{{ $review->reviewer_email }}</p>
                            </td>
                            <td class="px-6 py-3 text-xs text-gray-500">
                                {{ class_basename($review->reviewable_type) }} #{{ $review->reviewable_id }}
                            </td>
                            <td class="px-6 py-3 text-yellow-500">{{ str_repeat('★', $review->rating) }}</td>
                            <td class="px-6 py-3 max-w-xs truncate text-gray-600">{{ $review->comment ?? '—' }}</td>
                            <td class="px-6 py-3 text-gray-500">{{ $review->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-3">
                                <button type="button" class="text-red-500 hover:underline text-xs"
                                    @click="$dispatch('open-confirm', { message: 'Delete this review by {{ addslashes($review->reviewer_name) }}?', action: '{{ route('reviews.destroy', $review) }}' })">
                                    Delete
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="px-6 py-8 text-center text-gray-400">No reviews yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $reviews->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
