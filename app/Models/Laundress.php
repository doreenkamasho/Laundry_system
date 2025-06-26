<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Laundress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'verification_status'
    ];

    // Relationship with User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with LaundressDetail model
    public function details()
    {
        return $this->hasOne(LaundressDetail::class, 'user_id', 'user_id');
    }

    // Relationship with Review model
    public function reviews()
    {
        return $this->hasMany(Review::class, 'laundress_id', 'user_id');
    }

    // Get average rating
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    // Get total reviews count
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }
}