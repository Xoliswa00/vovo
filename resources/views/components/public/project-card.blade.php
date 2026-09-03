@props(['project'])

<a href="{{ route('projects.show.public', $project) }}" {{ $attributes->merge(['class' => 'card-brand h-full group']) }} data-aos="zoom-in">
    <div class="relative">
        @if($project->images->count())
            <img src="{{ asset($project->images->first()->image_path) }}" class="w-full h-52 object-cover" alt="{{ $project->title }}">
        @else
            <div class="w-full h-52 bg-slate-100 flex items-center justify-center">
                <i class="bi bi-hammer text-4xl text-muted"></i>
            </div>
        @endif
        @if($project->images->count() > 1)
            <span class="absolute bottom-2 right-2 badge-brand bg-navy/80 text-white text-[11px]">
                <i class="bi bi-images mr-1"></i>{{ $project->images->count() }}
            </span>
        @endif
    </div>

    <div class="flex flex-col flex-1 p-6">
        @if($project->category)
            <span class="badge-brand bg-accent/10 text-navy self-start mb-2">{{ $project->category }}</span>
        @endif
        <h5 class="font-heading font-bold text-navy mb-1 group-hover:text-accent transition-colors">{{ $project->title }}</h5>
        <p class="text-sm text-muted flex-1 mb-4">
            {{ \Illuminate\Support\Str::limit($project->summary ?: $project->description, 110) }}
        </p>

        <div class="flex items-center justify-between gap-3 mt-auto text-xs font-medium text-muted">
            <span>
                @if($project->completed_at)
                    <i class="bi bi-calendar3 mr-1"></i>{{ $project->completed_at->format('M Y') }}
                @elseif($project->location)
                    <i class="bi bi-geo-alt mr-1"></i>{{ $project->location }}
                @endif
            </span>
            <span class="font-bold text-accent whitespace-nowrap">View project <i class="bi bi-arrow-right"></i></span>
        </div>
    </div>
</a>
