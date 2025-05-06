<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function sales()
    {
        $sales = Booking::with('transaction')
            ->whereHas('transaction')
            ->latest()
            ->get();
            
        return view('admin.reports.sales', compact('sales'));
    }

    public function userActivity()
    {
        $users = User::withCount(['bookings', 'laundressBookings'])
            ->latest()
            ->get()
            ->map(function ($user) {
                $user->total_bookings = $user->bookings_count + $user->laundress_bookings_count;
                return $user;
            });

        return view('admin.reports.user-activity', compact('users'));
    }
}
