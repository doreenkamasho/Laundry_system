<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'laundress_id',
        'booking_id',
        'rating',
        'comment',
        'is_published'
    ];

    protected $casts = [
        'rating' => 'integer',
        'is_published' => 'boolean',
    ];
    
    protected $withCount = ['likes', 'replies'];
    
    protected $appends = ['is_liked'];

    /**
     * Get the laundress associated with this review
     */
    public function laundress()
    {
        return $this->belongsTo(Laundress::class, 'laundress_id', 'user_id');
    }

    /**
     * Get the customer who wrote this review
     */
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the booking associated with this review
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
    
    /**
     * Get the likes for this review
     */
    public function likes()
    {
        return $this->hasMany(ReviewLike::class);
    }
    
    /**
     * Get the replies for this review
     */
    public function replies()
    {
        return $this->hasMany(ReviewReply::class)->latest();
    }
    
    /**
     * Check if the current user has liked this review
     */
    public function getIsLikedAttribute()
    {
        if (!auth()->check()) {
            return false;
        }
        
        return $this->likes()->where('user_id', auth()->id())->exists();
    }
}
