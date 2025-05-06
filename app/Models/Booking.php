<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'laundress_id',
        'service_id',
        'selected_items',
        'scheduled_date',
        'scheduled_time',
        'pickup_required',
        'delivery_required',
        'pickup_fee',
        'delivery_fee',
        'total_amount',
        'status',
        'payment_status',
        'pickup_status',
        'delivery_status'
    ];

    protected $casts = [
        'scheduled_date' => 'datetime',
        'scheduled_time' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'selected_items' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function laundress()
    {
        return $this->belongsTo(User::class, 'laundress_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}