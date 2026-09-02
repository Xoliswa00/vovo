<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Support\ImageUpload;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // ─── Admin ──────────────────────────────────────────────────────────────

    public function index()
    {
        $this->authorize('viewAny', Project::class);

        $projects = Project::withCount('images')->ordered()->paginate(15);

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $this->authorize('create', Project::class);

        return view('projects.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Project::class);

        $validated = $this->validateProject($request);
        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_featured']  = $request->boolean('is_featured');

        $project = Project::create($validated);

        $this->storeImages($request, $project);

        return redirect()->route('projects.index')->with('success', 'Project added to the gallery.');
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        $project->load('images');

        return view('projects.create', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $validated = $this->validateProject($request);
        $validated['is_published'] = $request->boolean('is_published');
        $validated['is_featured']  = $request->boolean('is_featured');

        $project->update($validated);

        $this->storeImages($request, $project);

        return redirect()->route('projects.index')->with('success', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);

        foreach ($project->images as $img) {
            ImageUpload::delete($img->image_path);
        }

        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted.');
    }

    // ─── Public ─────────────────────────────────────────────────────────────

    public function publicIndex(Request $request)
    {
        $category = $request->query('category');

        $projects = Project::published()
            ->with('images')
            ->when($category, fn ($q) => $q->where('category', $category))
            ->ordered()
            ->paginate(12)
            ->withQueryString();

        $categories = Project::published()
            ->whereNotNull('category')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        return view('projects.public-index', compact('projects', 'categories', 'category'));
    }

    public function publicShow(Project $project)
    {
        abort_unless($project->is_published, 404);

        $project->load('images');

        $more = Project::published()
            ->whereKeyNot($project->id)
            ->with('images')
            ->ordered()
            ->take(3)
            ->get();

        return view('projects.public-show', compact('project', 'more'));
    }

    // ─── Helpers ────────────────────────────────────────────────────────────

    private function validateProject(Request $request): array
    {
        return $request->validate([
            'title'        => 'required|string|max:255',
            'summary'      => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'category'     => 'nullable|string|max:120',
            'materials'    => 'nullable|string|max:255',
            'client'       => 'nullable|string|max:255',
            'location'     => 'nullable|string|max:255',
            'completed_at' => 'nullable|date',
            'sort_order'   => 'nullable|integer|min:0',
            'is_published' => 'boolean',
            'is_featured'  => 'boolean',
            'images.*'     => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);
    }

    private function storeImages(Request $request, Project $project): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $hasPrimary = $project->images()->where('is_primary', true)->exists();

        foreach ($request->file('images') as $index => $image) {
            $project->images()->create([
                'image_path' => ImageUpload::store($image, index: $index),
                'is_primary' => ! $hasPrimary && $index === 0,
            ]);
        }
    }
}
