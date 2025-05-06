<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get user's data
        $userId = auth()->id();

        // Calculate orders statistics
        $totalOrders = Order::where('customer_id', $userId)->count();
        
        // Calculate orders growth
        $lastMonthOrders = Order::where('customer_id', $userId)
            ->whereMonth('created_at', Carbon::now()->subMonth())
            ->count();
            
        $ordersGrowth = $lastMonthOrders > 0 
            ? round((($totalOrders - $lastMonthOrders) / $lastMonthOrders) * 100, 1)
            : 0;

        // Get active orders
        $activeOrders = Order::where('customer_id', $userId)
            ->whereIn('status', ['pending', 'in_progress'])
            ->count();

        // Calculate total spent
        $totalSpent = Order::where('customer_id', $userId)
            ->where('payment_status', 'paid')
            ->sum('amount');

        // Get favorite laundress
        $favoriteLaundress = Order::where('customer_id', $userId)
            ->join('users', 'users.id', '=', 'orders.laundress_id')
            ->join('laundress_details', 'users.id', '=', 'laundress_details.user_id')
            ->select('users.id', 'users.name', 'laundress_details.avatar')
            ->selectRaw('COUNT(*) as order_count')
            ->groupBy('laundress_id', 'users.id', 'users.name', 'laundress_details.avatar')
            ->orderByDesc('order_count')
            ->first();

        // Get recent orders
        $recentOrders = Order::where('customer_id', $userId)
            ->with(['laundress.laundressDetail']) // Include laundressDetail relationship
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($order) {
                $order->status_color = match($order->status) {
                    'pending' => 'warning',
                    'in_progress' => 'info',
                    'completed' => 'success',
                    'cancelled' => 'danger',
                    default => 'secondary'
                };
                return $order;
            });

        return view('customer.dashboard', compact(
            'totalOrders',
            'ordersGrowth',
            'activeOrders',
            'totalSpent',
            'favoriteLaundress',
            'recentOrders'
        ));
    }
}