<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status');
        $user = auth()->user();

        // Query base
        $query = Booking::with(['customer', 'laundress', 'service', 'transaction'])
                       ->where('customer_id', $user->id);

        // Filter by status if provided
        if ($status) {
            $query->where('status', $status);
        }

        // Get orders
        $orders = $query->latest()->paginate(10);

        // Get counts for sidebar
        $orderCounts = [
            'all' => Booking::where('customer_id', $user->id)->count(),
            'pending' => Booking::where('customer_id', $user->id)
                              ->where('status', 'pending')
                              ->count(),
            'completed' => Booking::where('customer_id', $user->id)
                                ->where('status', 'completed')
                                ->count()
        ];

        return view('customer.orders.index', compact('orders', 'orderCounts', 'status'));
    }

    public function show(Booking $order)
    {
        // Check if order belongs to authenticated user
        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['customer', 'laundress', 'service', 'transaction']);
        return view('customer.orders.show', compact('order'));
    }

    public function cancel(Booking $order)
    {
        // Check if order belongs to authenticated user
        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }

        // Check if order can be cancelled
        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be cancelled.');
        }

        $order->update([
            'status' => 'cancelled',
            'cancelled_at' => now()
        ]);

        return back()->with('success', 'Order cancelled successfully.');
    }
}