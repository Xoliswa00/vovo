<?php

namespace App\Http\Controllers;

use App\Models\services;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ServicesController extends Controller
{
    public function index()
    {
        $services = services::with('category', 'vendor', 'images')->latest()->paginate(15);
        return view('services.index', compact('services'));
    }

    public function create()
    {
        $categories = Category::whereIn('type', ['service', 'both'])->get();
        $vendors    = Vendor::where('status', 'active')->get();
        return view('services.create', compact('categories', 'vendors'));
    }

    public function store(Request $request)
    {
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
        $service = services::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/img'), $filename);
                $service->images()->create(['image_path' => 'assets/img/' . $filename]);
            }
        }

        return redirect()->route('services.index')->with('success', 'Service created successfully!');
    }

    public function show(services $service)
    {
        $service->load('images', 'category', 'vendor', 'reviews');
        return view('services.show', compact('service'));
    }

    public function edit(services $service)
    {
        $categories = Category::whereIn('type', ['service', 'both'])->get();
        $vendors    = Vendor::where('status', 'active')->get();
        return view('services.create', compact('service', 'categories', 'vendors'));
    }

    public function update(Request $request, services $service)
    {
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

    public function destroy(services $service)
    {
        $service->delete();
        return redirect()->route('services.index')->with('success', 'Service deleted.');
    }

    // Public listing
    public function public(Request $request)
    {
        $categorySlug = $request->query('category');
        $search       = $request->query('search');

        $services = services::where('status', true)
            ->with('images', 'category', 'vendor')
            ->when($categorySlug, fn($q) => $q->whereHas('category', fn($c) => $c->where('slug', $categorySlug)))
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->latest()->paginate(12);

        $categories = Category::whereIn('type', ['service', 'both'])->withCount('services')->get();

        return view('GuestServices', compact('services', 'categories', 'categorySlug', 'search'));
    }

    // Public service detail
    public function publicShow(services $service)
    {
        $service->load('images', 'category', 'vendor', 'reviews');
        return view('services.public-show', compact('service'));
    }
}
