<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_name',
        'category_icon',
        'category_is_active',
        'name',
        'description',
        'price_structure',
        'is_active'
    ];

    protected $casts = [
        'price_structure' => 'array',
        'is_active' => 'boolean',
        'category_is_active' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Helper methods for category
    public function getCategoryAttribute()
    {
        return [
            'name' => $this->category_name,
            'icon' => $this->category_icon,
            'is_active' => $this->category_is_active
        ];
    }

    public function scopeActiveCategoryOnly($query)
    {
        return $query->where('category_is_active', true);
    }
}