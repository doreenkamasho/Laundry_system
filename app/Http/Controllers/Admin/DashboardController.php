<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total customers (users with role 'customer')
        $totalCustomers = User::whereHas('role', function($query) {
            $query->where('name', 'customer');
        })->count();

        // Get total laundress
        $totalLaundress = User::whereHas('role', function($query) {
            $query->where('name', 'laundress');
        })->count();

        // Get active orders
        $activeOrders = Booking::whereIn('status', ['pending', 'processing'])
            ->count();

        // Get total revenue
        $totalRevenue = Transaction::where('status', 'completed')
            ->sum('amount');

        // Get this month's revenue
        $monthlyRevenue = Transaction::where('status', 'completed')
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');

        // Get recent orders
        $recentOrders = Booking::with(['customer', 'laundress'])
            ->latest()
            ->take(5)
            ->get();

        // Get top laundress
        $topLaundress = User::whereHas('role', function($query) {
            $query->where('name', 'laundress');
        })
        ->withCount(['laundressBookings as total_orders' => function($query) {
            $query->where('status', 'completed');
        }])
        ->withSum(['laundressBookings as total_revenue' => function($query) {
            $query->where('status', 'completed');
        }], 'total_amount')
        ->orderByDesc('total_revenue')
        ->take(5)
        ->get();

        // Get recent activities
        $recentActivities = Booking::with(['customer', 'laundress'])
            ->latest()
            ->take(10)
            ->get()
            ->map(function($booking) {
                return (object)[
                    'title' => "New booking #{$booking->id}",
                    'description' => "{$booking->customer->name} booked {$booking->laundress->name}",
                    'created_at' => $booking->created_at
                ];
            });

        // Get revenue analytics data for the last 12 months
        $revenueData = Transaction::where('status', 'completed')
            ->whereBetween('created_at', [Carbon::now()->subMonths(11), Carbon::now()])
            ->select(
                DB::raw('SUM(amount) as total'),
                DB::raw("DATE_FORMAT(created_at, '%b %Y') as month")
            )
            ->groupBy('month')
            ->orderBy('created_at')
            ->get()
            ->map(function($item) {
                return [
                    'month' => $item->month,
                    'total' => (int)$item->total
                ];
            });

        return view('admin.dashboard', compact(
            'totalCustomers',
            'totalLaundress',
            'activeOrders',
            'totalRevenue',
            'monthlyRevenue',
            'recentOrders',
            'topLaundress',
            'recentActivities',
            'revenueData'
        ));
    }
}