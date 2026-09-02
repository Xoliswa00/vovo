<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectImage;
use App\Support\ImageUpload;
use Illuminate\Http\Request;

class ProjectImageController extends Controller
{
    /**
     * Upload one or more photos to an existing project.
     */
    public function store(Request $request, Project $project)
    {
        $this->authorize('update', $project);

        $request->validate([
            'images'   => 'required|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $hasPrimary = $project->images()->where('is_primary', true)->exists();

        foreach ($request->file('images') as $index => $image) {
            $project->images()->create([
                'image_path' => ImageUpload::store($image, index: $index),
                'is_primary' => ! $hasPrimary && $index === 0,
            ]);
        }

        return back()->with('success', 'Photos added.');
    }

    /**
     * Remove a single project photo.
     */
    public function destroy(ProjectImage $project_image)
    {
        $this->authorize('delete', $project_image);

        $project    = $project_image->project;
        $wasPrimary = $project_image->is_primary;

        ImageUpload::delete($project_image->image_path);

        $project_image->delete();

        if ($wasPrimary) {
            $project->images()->first()?->update(['is_primary' => true]);
        }

        return back()->with('success', 'Photo removed.');
    }

    /**
     * Set a photo as the project's cover/primary image.
     */
    public function primary(ProjectImage $project_image)
    {
        $this->authorize('update', $project_image);

        $project_image->project->images()->update(['is_primary' => false]);
        $project_image->update(['is_primary' => true]);

        return back()->with('success', 'Cover photo updated.');
    }
}
