<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class LaundressViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Share data with all views in Laundress folder
        View::composer(['Laundress.*', 'layouts.*'], function ($view) {
            if (Auth::check() && Auth::user()->hasRole('laundress')) {
                $pendingCount = Booking::where('laundress_id', Auth::id())
                    ->where('status', 'pending')
                    ->count();

                $ongoingCount = Booking::where('laundress_id', Auth::id())
                    ->whereIn('status', ['confirmed', 'in_progress'])
                    ->count();

                $completedCount = Booking::where('laundress_id', Auth::id())
                    ->where('status', 'completed')
                    ->count();

                $view->with([
                    'pendingOrdersCount' => $pendingCount,
                    'ongoingOrdersCount' => $ongoingCount,
                    'completedOrdersCount' => $completedCount
                ]);
            }
        });
    }
}
