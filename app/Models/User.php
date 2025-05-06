<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'role_id',
        'is_active',
        'theme_settings'  // Add this line
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'theme_settings' => 'array',
        'is_active' => 'boolean'
    ];

    protected $dates = [
        'last_login_at',
    ];

    protected $appends = ['average_rating', 'reviews_count'];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function adminDetail()
    {
        return $this->hasOne(AdminDetail::class);
    }

    public function customerDetail()
    {
        return $this->hasOne(CustomerDetail::class);
    }

    public function laundressDetail()
    {
        return $this->hasOne(LaundressDetail::class);
    }

    public function isAdmin()
    {
        return $this->role->name === 'admin';
    }

    public function isCustomer()
    {
        return $this->role->name === 'customer';
    }

    public function isLaundress()
    {
        return $this->role->name === 'laundress';
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    /**
     * Check if user has specific role
     *
     * @param string $role
     * @return bool
     */
    public function hasRole($role)
    {
        return $this->role->name === $role;
    }

    /**
     * Get the schedule associated with the user (laundress).
     * A laundress can only have one schedule.
     */
    public function schedule()
    {
        return $this->hasOne(Schedule::class)->withDefault([
            'working_days' => [
                'monday' => ['is_available' => true, 'start_time' => '08:00', 'end_time' => '17:00'],
                'tuesday' => ['is_available' => true, 'start_time' => '08:00', 'end_time' => '17:00'],
                'wednesday' => ['is_available' => true, 'start_time' => '08:00', 'end_time' => '17:00'],
                'thursday' => ['is_available' => true, 'start_time' => '08:00', 'end_time' => '17:00'],
                'friday' => ['is_available' => true, 'start_time' => '08:00', 'end_time' => '17:00'],
                'saturday' => ['is_available' => false, 'start_time' => '08:00', 'end_time' => '17:00'],
                'sunday' => ['is_available' => false, 'start_time' => '08:00', 'end_time' => '17:00'],
            ],
            'is_available' => true
        ]);
    }

    /**
     * Get the bookings associated with the user.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'customer_id');
    }

    public function laundressBookings()
    {
        return $this->hasMany(Booking::class, 'laundress_id');
    }

    /**
     * Get the services associated with the user (laundress).
     */
    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function createWallet()
    {
        return $this->wallet()->create([
            'balance' => 0,
            'status' => 'active'
        ]);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'laundress_id');
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }

    protected function themeSettings(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? json_decode($value, true) : [
                'theme' => 'light',
                'layoutStyle' => 'default',
                'sidebar' => 'light',
                'sidebarSize' => 'lg',
                'sidebarImage' => 'none'
            ],
            set: fn ($value) => is_array($value) ? json_encode($value) : $value
        );
    }
}
