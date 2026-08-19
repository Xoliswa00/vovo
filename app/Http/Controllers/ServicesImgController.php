<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\services_img;
use Illuminate\Http\Request;

class ServicesImgController extends Controller
{
    /**
     * Upload one or more photos to an existing service.
     */
    public function store(Request $request, Service $service)
    {
        $this->authorize('update', $service);

        $request->validate([
            'images'   => 'required|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $hasPrimary = $service->images()->where('is_primary', true)->exists();

        foreach ($request->file('images') as $index => $image) {
            $filename = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('assets/img'), $filename);

            $service->images()->create([
                'image_path' => 'assets/img/' . $filename,
                'is_primary' => ! $hasPrimary && $index === 0,
            ]);
        }

        return back()->with('success', 'Photos added.');
    }

    /**
     * Remove a single service photo.
     */
    public function destroy(services_img $services_img)
    {
        $this->authorize('delete', $services_img);

        $service = $services_img->service;
        $wasPrimary = $services_img->is_primary;

        if (str_starts_with($services_img->image_path, 'assets/img/') && file_exists(public_path($services_img->image_path))) {
            @unlink(public_path($services_img->image_path));
        }

        $services_img->delete();

        if ($wasPrimary) {
            $service->images()->first()?->update(['is_primary' => true]);
        }

        return back()->with('success', 'Photo removed.');
    }

    /**
     * Set a photo as the service's cover/primary image.
     */
    public function primary(services_img $services_img)
    {
        $this->authorize('update', $services_img);

        $services_img->service->images()->update(['is_primary' => false]);
        $services_img->update(['is_primary' => true]);

        return back()->with('success', 'Cover photo updated.');
    }
}
