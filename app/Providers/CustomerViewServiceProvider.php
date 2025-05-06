<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Booking;

class CustomerViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        View::composer('Customer.sidebar.sidebar', function ($view) {
            $user = auth()->user();
            
            if ($user) {
                $bookingCounts = [
                    'all' => Booking::where('customer_id', $user->id)->count(),
                    'pending' => Booking::where('customer_id', $user->id)
                        ->where('status', 'pending')->count(),
                    'confirmed' => Booking::where('customer_id', $user->id)
                        ->where('status', 'confirmed')->count(),
                    'completed' => Booking::where('customer_id', $user->id)
                        ->where('status', 'completed')->count(),
                ];
            } else {
                $bookingCounts = [
                    'all' => 0,
                    'pending' => 0,
                    'confirmed' => 0,
                    'completed' => 0,
                ];
            }

            $view->with('bookingCounts', $bookingCounts);
        });
    }
}