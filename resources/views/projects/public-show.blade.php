@extends('layouts.public')

@section('title', $project->title . ' — Our Work — Nobela Enterprises')
@section('meta_description', \Illuminate\Support\Str::limit($project->summary ?: $project->description ?: $project->title . ' — a fabrication project by Nobela Enterprises.', 155))
@section('og_image', $project->images->count() ? asset($project->images->first()->image_path) : asset('assets/img/nobela-mark.png'))

@section('content')
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav aria-label="breadcrumb" class="mb-6 text-sm text-muted">
            <a href="{{ route('projects.public') }}" class="hover:text-accent">Our Work</a>
            @if($project->category)
                <span class="mx-1">/</span>
                <a href="{{ route('projects.public', ['category' => $project->category]) }}" class="hover:text-accent">{{ $project->category }}</a>
            @endif
            <span class="mx-1">/</span><span class="text-navy font-medium">{{ $project->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            {{-- Gallery --}}
            <div>
                @if($project->images->count())
                    <div x-data="{ active: 0 }">
                        <div class="rounded-2xl overflow-hidden shadow-lg relative bg-slate-100">
                            @foreach($project->images as $i => $img)
                                <img x-show="active === {{ $i }}" src="{{ asset($img->image_path) }}" class="w-full h-[420px] object-cover" alt="{{ $img->caption ?: $project->title }}">
                            @endforeach
                            @if($project->images->count() > 1)
                                <button type="button" @click="active = active === 0 ? {{ $project->images->count() - 1 }} : active - 1" class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/90 shadow flex items-center justify-center hover:bg-white" aria-label="Previous image">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button type="button" @click="active = active === {{ $project->images->count() - 1 }} ? 0 : active + 1" class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-white/90 shadow flex items-center justify-center hover:bg-white" aria-label="Next image">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            @endif
                        </div>
                        @if($project->images->count() > 1)
                            <div class="gallery-thumbs">
                                @foreach($project->images as $i => $img)
                                    <button type="button" @click="active = {{ $i }}" :class="active === {{ $i }} ? 'active' : ''" aria-label="View image {{ $i + 1 }}">
                                        <img src="{{ asset($img->image_path) }}" alt="">
                                    </button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <div class="rounded-2xl bg-slate-100 flex items-center justify-center h-[420px]">
                        <i class="bi bi-hammer text-5xl text-muted"></i>
                    </div>
                @endif
            </div>

            {{-- Details --}}
            <div>
                @if($project->category)<span class="badge-brand bg-accent text-white mb-2">{{ $project->category }}</span>@endif
                <h1 class="text-2xl font-bold font-heading text-navy mb-2">{{ $project->title }}</h1>
                @if($project->summary)<p class="text-lg text-muted mb-4">{{ $project->summary }}</p>@endif

                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-3 mb-6">
                    @if($project->client)
                        <div><dt class="text-xs uppercase tracking-wide text-muted">Client</dt><dd class="text-navy font-medium">{{ $project->client }}</dd></div>
                    @endif
                    @if($project->location)
                        <div><dt class="text-xs uppercase tracking-wide text-muted">Location</dt><dd class="text-navy font-medium">{{ $project->location }}</dd></div>
                    @endif
                    @if($project->materials)
                        <div><dt class="text-xs uppercase tracking-wide text-muted">Materials</dt><dd class="text-navy font-medium">{{ $project->materials }}</dd></div>
                    @endif
                    @if($project->completed_at)
                        <div><dt class="text-xs uppercase tracking-wide text-muted">Completed</dt><dd class="text-navy font-medium">{{ $project->completed_at->format('F Y') }}</dd></div>
                    @endif
                </dl>

                @if($project->description)
                    <div class="text-sm leading-relaxed text-muted space-y-3">
                        {!! nl2br(e($project->description)) !!}
                    </div>
                @endif

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('quote.create') }}" class="btn-brand-primary btn-brand-sm">Start a project like this</a>
                    <a href="{{ route('projects.public') }}" class="btn-brand-outline btn-brand-sm">Back to Our Work</a>
                </div>
            </div>
        </div>

        @if($more->count())
            <div class="mt-16">
                <h4 class="text-xl font-bold font-heading text-navy mb-6">More of our work</h4>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($more as $project)
                        <x-public.project-card :project="$project" />
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
