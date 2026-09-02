@extends('layouts.public')

@section('title', 'Our Work — Nobela Enterprises')
@section('meta_description', 'A gallery of fabrication and boilermaking projects designed and built by Nobela Enterprises — structural steel, pressure vessels, piping, repairs and custom builds.')

@section('content')
<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="section-title text-center mb-10" data-aos="fade-up">
            <h2>Our Work</h2>
            <p>Fabrication and boilermaking projects we've designed, built and delivered.</p>
        </div>

        @if($categories->count())
            <div class="flex flex-wrap justify-center gap-2 mb-8">
                <a href="{{ route('projects.public') }}" @class(['marketplace-category-pill', 'ring-2 ring-accent font-semibold' => ! $category])>All</a>
                @foreach($categories as $cat)
                    <a href="{{ route('projects.public', ['category' => $cat]) }}" @class(['marketplace-category-pill', 'ring-2 ring-accent font-semibold' => $category === $cat])>{{ $cat }}</a>
                @endforeach
            </div>
        @endif

        @if($projects->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">🔧</div>
                <h5>Nothing to show here yet</h5>
                <p class="mt-2">{{ $category ? 'No projects in this category yet.' : 'Project photos are on their way.' }}</p>
                @if($category)
                    <a href="{{ route('projects.public') }}" class="btn-brand-outline mt-3">View all work</a>
                @endif
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($projects as $project)
                    <x-public.project-card :project="$project" />
                @endforeach
            </div>
            <div class="mt-10">{{ $projects->withQueryString()->links() }}</div>
        @endif
    </div>
</section>
@endsection
