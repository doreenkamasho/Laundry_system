<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'laundress_id',
        'order_number',
        'status',
        'amount',
        'payment_method',
        'payment_status'
    ];

    const STATUSES = [
        'pending',
        'in_progress',
        'completed',
        'cancelled'
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function laundress()
    {
        return $this->belongsTo(User::class, 'laundress_id');
    }
}