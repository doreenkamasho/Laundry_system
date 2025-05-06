<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'reference',
        'booking_id',
        'wallet_id',
        'amount',
        'type',
        'status',
        'provider',
        'phone_number',
        'description'
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public static function generateReference()
    {
        return 'TXN-' . strtoupper(uniqid());
    }
}