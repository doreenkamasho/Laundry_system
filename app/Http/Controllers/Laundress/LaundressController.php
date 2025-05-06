<?php

namespace App\Http\Controllers\Laundress;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaundressController extends Controller
{
    public function dashboard()
    {
        $laundress = auth()->user();
        // Add statistics/data for dashboard
        $stats = [
            'total_orders' => 0,
            'pending_orders' => 0,
            'completed_orders' => 0,
            'today_earnings' => 0,
            'month_earnings' => 0
        ];
        
        return view('laundress.dashboard', compact('laundress', 'stats'));
    }
}