<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Admin listing
    public function index()
    {
        $products = Product::with('category', 'vendor')->latest()->paginate(15);
        return view('marketplace.admin.index', compact('products'));
    }

    // Public listing
    public function publicIndex(Request $request)
    {
        $categorySlug = $request->query('category');
        $search       = $request->query('search');

        $products = Product::where('status', 'active')
            ->with('images', 'category', 'vendor')
            ->when($categorySlug, fn($q) => $q->whereHas('category', fn($c) => $c->where('slug', $categorySlug)))
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->latest()
            ->paginate(12);

        $categories = Category::whereIn('type', ['product', 'both'])->withCount('products')->get();

        return view('marketplace.index', compact('products', 'categories', 'categorySlug', 'search'));
    }

    // Public product detail
    public function publicShow(Product $product)
    {
        $product->load('images', 'category', 'vendor', 'reviews');
        $related = Product::where('status', 'active')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->with('images')
            ->take(4)->get();

        return view('marketplace.show', compact('product', 'related'));
    }

    public function create()
    {
        $categories = Category::whereIn('type', ['product', 'both'])->get();
        $vendors    = Vendor::where('status', 'active')->get();
        return view('marketplace.admin.create', compact('categories', 'vendors'));
    }

    public function store(Request $request)
    {
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

    public function edit(Product $product)
    {
        $categories = Category::whereIn('type', ['product', 'both'])->get();
        $vendors    = Vendor::where('status', 'active')->get();
        return view('marketplace.admin.create', compact('product', 'categories', 'vendors'));
    }

    public function update(Request $request, Product $product)
    {
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
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
}
