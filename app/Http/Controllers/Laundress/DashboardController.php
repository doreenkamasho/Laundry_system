<?php

namespace App\Http\Controllers\Laundress;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Calculate statistics
        $stats = [
            'totalOrders' => Booking::where('laundress_id', $user->id)->count(),
            'totalEarnings' => Booking::where('laundress_id', $user->id)
                ->whereHas('transaction', function($query) {
                    $query->where('status', 'completed');
                })->sum('total_amount'),
            'pendingOrders' => Booking::where('laundress_id', $user->id)
                ->where('status', 'pending')->count(),
            'completedOrders' => Booking::where('laundress_id', $user->id)
                ->where('status', 'completed')->count(),
            'monthlyEarnings' => Booking::where('laundress_id', $user->id)
                ->whereHas('transaction', function($query) {
                    $query->where('status', 'completed');
                })
                ->whereMonth('created_at', Carbon::now()->month)
                ->sum('total_amount')
        ];

        // Get chart data
        $charts = [
            'ordersTrend' => $this->getOrdersTrend($user->id),
            'earningsTrend' => $this->getEarningsTrend($user->id),
            'monthlyEarnings' => $this->getMonthlyEarnings($user->id),
            'months' => $this->getLast12Months(),
            'ordersByStatus' => $this->getOrdersByStatus($user->id)
        ];

        // Get recent orders
        $recentOrders = Booking::where('laundress_id', $user->id)
            ->with(['customer', 'service', 'transaction'])
            ->latest()
            ->take(5)
            ->get();

        return view('Laundress.dashboard', compact('stats', 'charts', 'recentOrders'));
    }

    private function getOrdersTrend($userId)
    {
        return Booking::where('laundress_id', $userId)
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->pluck('count')
            ->toArray();
    }

    private function getEarningsTrend($userId)
    {
        return Booking::where('laundress_id', $userId)
            ->whereHas('transaction', function($query) {
                $query->where('status', 'completed');
            })
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('sum(total_amount) as total'))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->limit(7)
            ->pluck('total')
            ->toArray();
    }

    private function getMonthlyEarnings($userId)
    {
        $earnings = [];
        for ($i = 1; $i <= 12; $i++) {
            $earnings[] = Booking::where('laundress_id', $userId)
                ->whereHas('transaction', function($query) {
                    $query->where('status', 'completed');
                })
                ->whereMonth('created_at', $i)
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('total_amount');
        }
        return $earnings;
    }

    private function getLast12Months()
    {
        return collect(range(1, 12))->map(function($month) {
            return Carbon::create(null, $month)->format('M');
        })->toArray();
    }

    private function getOrdersByStatus($userId)
    {
        $statuses = ['pending', 'processing', 'completed'];
        return collect($statuses)->map(function($status) use ($userId) {
            return Booking::where('laundress_id', $userId)
                ->where('status', $status)
                ->count();
        })->toArray();
    }
}