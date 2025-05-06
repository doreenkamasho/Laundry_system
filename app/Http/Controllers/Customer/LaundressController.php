<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;

class LaundressController extends Controller
{
    public function index()
    {
        $laundresses = User::whereHas('role', function($query) {
            $query->where('name', 'laundress');
        })->with(['laundressDetail'])->get();

        return view('Customer.find-laundress.index', compact('laundresses'));
    }

    public function show($id)
    {
        $laundress = User::with(['laundressDetail', 'services', 'schedule'])
            ->findOrFail($id);

        // Get schedule information
        $schedule = $laundress->schedule;
        $availableDays = $schedule->available_days;
        
        // Get Monday's working hours as an example
        $mondayHours = null;
        if ($schedule->isAvailableOn('monday')) {
            $mondayHours = $schedule->getWorkingHours('monday');
        }

        return view('Customer.laundress.profile', compact('laundress', 'availableDays', 'mondayHours'));
    }

    /**
     * Display reviews for a specific laundress
     */
    public function reviews(User $laundress)
    {
        // Check if user is a laundress
        if (!$laundress->hasRole('laundress')) {
            abort(404, 'Laundress not found');
        }
        
        $reviews = Review::where('laundress_id', $laundress->id)
            ->with('customer')
            ->where('is_published', true)
            ->latest()
            ->paginate(10);
            
        return view('Customer.laundress.reviews', [
            'laundress' => $laundress,
            'reviews' => $reviews
        ]);
    }

    /**
     * Store a new review for a laundress
     */
    public function storeReview(Request $request, User $laundress)
    {
        \Log::info('Review submission started', [
            'request_data' => $request->all(),
            'is_ajax' => $request->ajax(),
            'auth_user_id' => auth()->id()
        ]);
        
        // Remove min:10 from comment validation
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);
        
        // Check for duplicate reviews - prevent multiple submissions
        $existingReview = Review::where('customer_id', auth()->id())
            ->where('laundress_id', $laundress->id)
            ->where('created_at', '>', now()->subMinutes(5))
            ->first();
            
        if ($existingReview) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => [
                        'general' => ['You have already submitted a review recently.']
                    ]
                ], 422);
            }
            return redirect()->back()
                ->with('error', 'You have already submitted a review recently.')
                ->withInput();
        }
        
        try {
            // Create the review
            $review = new Review();
            $review->laundress_id = $laundress->id;
            $review->customer_id = auth()->id();
            $review->rating = $request->rating;
            $review->comment = $request->comment;
            $review->is_published = true;
            $review->save();
            
            // Reload the customer relationship for the view
            $review->load('customer');
            
            \Log::info('Review saved successfully', [
                'review_id' => $review->id,
                'is_ajax' => $request->ajax()
            ]);
            
            if ($request->ajax()) {
                try {
                    $reviewHtml = view('Customer.laundress.partials.review-item', [
                        'review' => $review,
                        'loop' => (object)['last' => true]
                    ])->render();
                    
                    return response()->json([
                        'success' => true,
                        'review_html' => $reviewHtml,
                        'average_rating' => number_format($laundress->average_rating, 1),
                        'reviews_count' => $laundress->reviews_count
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Error rendering review partial', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Review saved but could not render HTML',
                        'error_details' => $e->getMessage(),
                        'average_rating' => number_format($laundress->average_rating, 1),
                        'reviews_count' => $laundress->reviews_count
                    ]);
                }
            }
            
            return redirect()->back()->with('success', 'Your review has been posted successfully!');
        } 
        catch (\Exception $e) {
            \Log::error('Review submission error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong while saving your review.',
                    'error_details' => $e->getMessage()
                ], 500);
            }
            
            return redirect()->back()
                ->with('error', 'Something went wrong while posting your review.')
                ->withInput();
        }
    }

    /**
     * Handle like/unlike for a review
     */
    public function likeReview(Review $review)
    {
        $user = auth()->user();
        
        // Check if the user has already liked this review
        $existingLike = $review->likes()->where('user_id', $user->id)->first();
        
        if ($existingLike) {
            // User already liked it, so unlike
            $existingLike->delete();
            $liked = false;
        } else {
            // User hasn't liked it, so add like
            $review->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }
        
        return response()->json([
            'success' => true,
            'liked' => $liked,
            'likes_count' => $review->likes()->count()
        ]);
    }

    /**
     * Store a reply to a review
     */
    public function replyToReview(Request $request, Review $review)
    {
        $request->validate([
            'content' => 'required|string|min:2|max:500'
        ]);
        
        $reply = $review->replies()->create([
            'user_id' => auth()->id(),
            'content' => $request->content
        ]);
        
        return response()->json([
            'success' => true,
            'reply' => [
                'id' => $reply->id,
                'content' => $reply->content,
                'user' => [
                    'name' => $reply->user->name,
                    'avatar' => $reply->user->avatar,
                    'initials' => substr($reply->user->name, 0, 1)
                ],
                'created_at_diff' => $reply->created_at->diffForHumans(),
            ],
            'replies_count' => $review->replies()->count()
        ]);
    }

    /**
     * Get replies for a review
     */
    public function getReviews(Review $review)
    {
        $replies = $review->replies()->with('user')->latest()->get();
        
        $formattedReplies = $replies->map(function($reply) {
            return [
                'id' => $reply->id,
                'content' => $reply->content,
                'user' => [
                    'name' => $reply->user->name,
                    'avatar' => $reply->user->avatar,
                    'initials' => substr($reply->user->name, 0, 1)
                ],
                'created_at_diff' => $reply->created_at->diffForHumans(),
            ];
        });
        
        return response()->json([
            'success' => true,
            'replies' => $formattedReplies
        ]);
    }
}