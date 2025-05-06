<?php

namespace App\Http\Controllers\Laundress;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EarningsController extends Controller
{
    public function overview()
    {
        $user = auth()->user();

        // Get monthly earnings for completed transactions
        $earnings = Booking::where('laundress_id', $user->id)
            ->whereHas('transaction', function($query) {
                $query->where('status', 'completed');
            })
            ->select(
                DB::raw('SUM(total_amount) as total_earnings'),
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month')
            )
            ->groupBy('month')
            ->orderBy('month', 'desc')
            ->get();

        // Calculate total stats
        $totalStats = Booking::where('laundress_id', $user->id)
            ->whereHas('transaction', function($query) {
                $query->where('status', 'completed');
            })
            ->select(
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_amount) as total_earnings')
            )
            ->first();

        $totalEarnings = $totalStats->total_earnings ?? 0;
        $totalOrders = $totalStats->total_orders ?? 0;

        // Get current month stats
        $currentMonthEarnings = $earnings->where('month', Carbon::now()->format('Y-m'))->first();

        return view('Laundress.earnings.overview', compact(
            'earnings',
            'totalEarnings',
            'totalOrders',
            'currentMonthEarnings'
        ));
    }

    public function history()
    {
        $bookings = Booking::where('laundress_id', auth()->id())
            ->whereHas('transaction', function($query) {
                $query->where('status', 'completed');
            })
            ->with(['customer', 'service', 'transaction'])
            ->latest()
            ->paginate(10);

        return view('Laundress.earnings.history', compact('bookings'));
    }
}