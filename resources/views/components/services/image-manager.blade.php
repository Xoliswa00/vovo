@props(['service'])

@if($service->images->count())
    <div x-data class="flex gap-3 mt-2 flex-wrap">
        @foreach($service->images as $img)
            <div class="relative group w-24 h-24 rounded-lg overflow-hidden border {{ $img->is_primary ? 'ring-2 ring-accent' : 'border-gray-200' }}">
                <img src="{{ asset($img->image_path) }}" class="w-full h-full object-cover">

                @if($img->is_primary)
                    <span class="absolute bottom-0 inset-x-0 bg-accent text-white text-[10px] text-center py-0.5 font-semibold">Cover</span>
                @else
                    <form method="POST" action="{{ route('services.images.primary', $img) }}" class="absolute bottom-0 inset-x-0">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="w-full bg-black/60 text-white text-[10px] py-0.5 opacity-0 group-hover:opacity-100 transition-opacity">
                            Set as cover
                        </button>
                    </form>
                @endif

                <button
                    type="button"
                    @click="$dispatch('open-confirm', { message: 'Delete this photo?', action: '{{ route('services.images.destroy', $img) }}', method: 'DELETE' })"
                    class="absolute top-1 right-1 w-5 h-5 rounded-full bg-red-600 text-white text-xs flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity"
                    aria-label="Delete photo"
                >&times;</button>
            </div>
        @endforeach
    </div>
@endif
