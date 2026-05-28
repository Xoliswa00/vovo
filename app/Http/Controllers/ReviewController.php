<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\services;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with('reviewable')->latest()->paginate(20);
        return view('reviews.index', compact('reviews'));
    }

    public function store(Request $request, string $type, int $id)
    {
        $request->validate([
            'reviewer_name'  => 'required|string|max:255',
            'reviewer_email' => 'required|email',
            'rating'         => 'required|integer|min:1|max:5',
            'comment'        => 'nullable|string|max:1000',
        ]);

        $model = match ($type) {
            'product' => Product::findOrFail($id),
            'service' => services::findOrFail($id),
            default   => abort(404),
        };

        $model->reviews()->create([
            'reviewer_name'  => $request->reviewer_name,
            'reviewer_email' => $request->reviewer_email,
            'rating'         => $request->rating,
            'comment'        => $request->comment,
        ]);

        return back()->with('success', 'Thank you for your review!');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Review deleted.');
    }
}
