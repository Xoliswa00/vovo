<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Admin/vendor listing
    public function index(Request $request)
    {
        $this->authorize('viewAny', Product::class);

        $products = Product::with('category', 'vendor')
            ->when($request->user()->isVendor(), fn($q) => $q->where('vendor_id', $request->user()->vendor?->id))
            ->latest()->paginate(15);

        return view('marketplace.admin.index', compact('products'));
    }

    // Public listing
    public function publicIndex(Request $request)
    {
        $categorySlug = $request->query('category');
        $search       = $request->query('search');
        $sort         = $request->query('sort', 'newest');

        $products = Product::where('status', 'active')
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

        $categories = Category::whereIn('type', ['product', 'both'])->withCount('products')->get();

        return view('marketplace.index', compact('products', 'categories', 'categorySlug', 'search', 'sort'));
    }

    // Public product detail
    public function publicShow(Product $product)
    {
        $product->load('images', 'category', 'vendor', 'reviews');
        $product->loadCount('reviews')->loadAvg('reviews as reviews_avg_rating', 'rating');
        $related = Product::where('status', 'active')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('images')
            ->withCount('reviews')
            ->withAvg('reviews as reviews_avg_rating', 'rating')
            ->take(4)->get();

        return view('marketplace.show', compact('product', 'related'));
    }

    public function create(Request $request)
    {
        $this->authorize('create', Product::class);

        $categories = Category::whereIn('type', ['product', 'both'])->get();
        $vendors    = $request->user()->isAdmin() ? Vendor::where('status', 'active')->get() : collect();
        return view('marketplace.admin.create', compact('categories', 'vendors'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Product::class);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'vendor_id'   => 'nullable|exists:vendors,id',
            'status'      => 'required|in:active,inactive',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        if ($request->user()->isVendor()) {
            abort_if(! $request->user()->vendor, 403, 'Your vendor profile has not been set up yet. Contact an administrator.');
            $validated['vendor_id'] = $request->user()->vendor->id;
        }

        $product = Product::create($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/img/products'), $filename);
                $product->images()->create(['image_path' => 'assets/img/products/' . $filename]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created.');
    }

    public function show(Product $product)
    {
        return redirect()->route('marketplace.show', $product);
    }

    public function edit(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $categories = Category::whereIn('type', ['product', 'both'])->get();
        $vendors    = $request->user()->isAdmin() ? Vendor::where('status', 'active')->get() : collect();
        return view('marketplace.admin.create', compact('product', 'categories', 'vendors'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'vendor_id'   => 'nullable|exists:vendors,id',
            'status'      => 'required|in:active,inactive',
            'images.*'    => 'image|mimes:jpg,jpeg,png,webp|max:3072',
        ]);

        if ($request->user()->isVendor()) {
            $validated['vendor_id'] = $product->vendor_id;
        }

        $product->update($validated);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('assets/img/products'), $filename);
                $product->images()->create(['image_path' => 'assets/img/products/' . $filename]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
}
