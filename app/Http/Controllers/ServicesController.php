<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('viewAny', Service::class);

        $services = Service::with('category', 'vendor', 'images')
            ->when($request->user()->isVendor(), fn($q) => $q->where('vendor_id', $request->user()->vendor?->id))
            ->latest()->paginate(15);

        return view('services.index', compact('services'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', Service::class);

        $categories = Category::whereIn('type', ['service', 'both'])->get();
        $vendors    = $request->user()->isAdmin() ? Vendor::where('status', 'active')->get() : collect();
        return view('services.create', compact('categories', 'vendors'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Service::class);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'vendor_id'   => 'nullable|exists:vendors,id',
            'price'       => 'nullable|numeric|min:0',
            'location'    => 'nullable|string|max:255',
            'status'      => 'boolean',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['status'] = $request->boolean('status');

        if ($request->user()->isVendor()) {
            abort_if(! $request->user()->vendor, 403, 'Your vendor profile has not been set up yet. Contact an administrator.');
            $validated['vendor_id'] = $request->user()->vendor->id;
        }

        $service = Service::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/img'), $filename);
                $service->images()->create(['image_path' => 'assets/img/' . $filename]);
            }
        }

        return redirect()->route('services.index')->with('success', 'Service created successfully!');
    }

    public function show(Service $service)
    {
        $this->authorize('view', $service);

        $service->load('images', 'category', 'vendor', 'reviews');
        return view('services.show', compact('service'));
    }

    public function edit(Request $request, Service $service)
    {
        $this->authorize('update', $service);

        $categories = Category::whereIn('type', ['service', 'both'])->get();
        $vendors    = $request->user()->isAdmin() ? Vendor::where('status', 'active')->get() : collect();
        return view('services.create', compact('service', 'categories', 'vendors'));
    }

    public function update(Request $request, Service $service)
    {
        $this->authorize('update', $service);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'vendor_id'   => 'nullable|exists:vendors,id',
            'price'       => 'nullable|numeric|min:0',
            'location'    => 'nullable|string|max:255',
            'status'      => 'boolean',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['status'] = $request->boolean('status');

        if ($request->user()->isVendor()) {
            $validated['vendor_id'] = $service->vendor_id;
        }

        $service->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/img'), $filename);
                $service->images()->create(['image_path' => 'assets/img/' . $filename]);
            }
        }

        return redirect()->route('services.index')->with('success', 'Service updated.');
    }

    public function destroy(Service $service)
    {
        $this->authorize('delete', $service);

        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted.');
    }

    // Public listing
    public function public(Request $request)
    {
        $categorySlug = $request->query('category');
        $search       = $request->query('search');
        $sort         = $request->query('sort', 'newest');

        $services = Service::where('status', true)
            ->with('images', 'category', 'vendor')
            ->withCount('reviews')
            ->withAvg('reviews as reviews_avg_rating', 'rating')
            ->when($categorySlug, fn($q) => $q->whereHas('category', fn($c) => $c->where('slug', $categorySlug)))
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->when($sort === 'price_asc', fn($q) => $q->orderBy('price', 'asc'))
            ->when($sort === 'price_desc', fn($q) => $q->orderBy('price', 'desc'))
            ->when($sort === 'rating', fn($q) => $q->orderByDesc('reviews_avg_rating'))
            ->when(!in_array($sort, ['price_asc', 'price_desc', 'rating']), fn($q) => $q->latest())
            ->paginate(12)
            ->withQueryString();

        $categories = Category::whereIn('type', ['service', 'both'])->withCount('services')->get();

        return view('GuestServices', compact('services', 'categories', 'categorySlug', 'search', 'sort'));
    }

    // Public service detail
    public function publicShow(Service $service)
    {
        $service->load('images', 'category', 'vendor', 'reviews');
        $service->loadCount('reviews')->loadAvg('reviews as reviews_avg_rating', 'rating');
        return view('services.public-show', compact('service'));
    }
}
