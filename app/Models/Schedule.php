<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'working_days',
        'is_available'
    ];

    protected $casts = [
        'working_days' => 'array',
        'is_available' => 'boolean'
    ];

    /**
     * Get the user (laundress) that owns the schedule.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the available working days.
     */
    public function getAvailableDaysAttribute()
    {
        return collect($this->working_days)
            ->filter(function ($day) {
                return $day['is_available'];
            })
            ->keys()
            ->toArray();
    }

    /**
     * Check if the laundress is available on a specific day.
     */
    public function isAvailableOn($dayName)
    {
        return $this->working_days[strtolower($dayName)]['is_available'] ?? false;
    }

    /**
     * Get working hours for a specific day.
     */
    public function getWorkingHours($dayName)
    {
        $day = $this->working_days[strtolower($dayName)] ?? null;
        if (!$day || !$day['is_available']) {
            return null;
        }

        return [
            'start' => $day['start_time'],
            'end' => $day['end_time']
        ];
    }
}