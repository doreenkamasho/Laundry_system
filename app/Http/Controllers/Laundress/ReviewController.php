<?php

namespace App\Http\Controllers\Laundress;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::where('laundress_id', auth()->id())
            ->with(['customer', 'booking'])
            ->latest()
            ->paginate(10);

        return view('laundress.reviews.index', compact('reviews'));
    }

    public function show(Review $review)
    {
        $this->authorize('view', $review);
        
        $review->load(['customer', 'booking']);
        
        return view('laundress.reviews.show', compact('review'));
    }

    public function togglePublish(Review $review)
    {
        $this->authorize('update', $review);
        
        $review->update([
            'is_published' => !$review->is_published
        ]);

        return back()->with('success', 'Review status updated successfully');
    }
}