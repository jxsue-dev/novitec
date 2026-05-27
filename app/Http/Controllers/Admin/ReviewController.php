<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::orderByDesc('created_at')->get();
        return view('admin.reviews', compact('reviews'));
    }

    public function toggleFeatured(Review $review)
    {
        $featured_count = Review::where('featured', true)->count();

        if (!$review->featured && $featured_count >= 4) {
            return back()->with('error', 'Solo puedes destacar máximo 4 reseñas. Quita una antes de destacar otra.');
        }

        $review->update(['featured' => !$review->featured]);
        return back()->with('success', $review->featured ? 'Reseña destacada.' : 'Reseña quitada de destacados.');
    }

    public function destroy(Review $review)
    {
        $review->delete();
        return back()->with('success', 'Reseña eliminada.');
    }
}
