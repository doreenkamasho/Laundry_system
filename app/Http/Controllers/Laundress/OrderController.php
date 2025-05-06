<?php

namespace App\Http\Controllers\Laundress;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Carbon\Carbon;
use App\Events\OrderStatusUpdated;
use Illuminate\Support\Facades\Notification;
use App\Notifications\OrderStatusChanged;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status', 'pending');

        // Get count for sidebar badges
        $pendingOrdersCount = Booking::where('laundress_id', auth()->id())
            ->where('status', 'pending')
            ->count();

        $ongoingOrdersCount = Booking::where('laundress_id', auth()->id())
            ->whereIn('status', ['confirmed', 'washing', 'drying', 'ironing', 'packaging'])
            ->count();

        $completedOrdersCount = Booking::where('laundress_id', auth()->id())
            ->where('status', 'completed')
            ->count();

        // Get orders based on status
        $orders = Booking::where('laundress_id', auth()->id())
            ->when($status === 'pending', function ($query) {
                return $query->where('status', 'pending');
            })
            ->when($status === 'in_progress', function ($query) {
                return $query->whereIn('status', ['confirmed', 'washing', 'drying', 'ironing', 'packaging']);
            })
            ->when($status === 'completed', function ($query) {
                return $query->where('status', 'completed');
            })
            ->with(['customer', 'service'])
            ->latest()
            ->paginate(10);

        return view('Laundress.orders.index', compact(
            'orders',
            'status',
            'pendingOrdersCount',
            'ongoingOrdersCount',
            'completedOrdersCount'
        ));
    }

    public function show(Booking $order)
    {
        // Check if the order belongs to this laundress
        if ($order->laundress_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Eager load relationships
        $order->load(['customer', 'service']);

        return view('Laundress.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Booking $order)
    {
        $request->validate([
            'status' => 'required|in:confirmed,washing,drying,ironing,packaging,completed'
        ]);

        if ($order->laundress_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $newStatus = $request->status;
        $now = now(); // Get current timestamp

        // Update status and corresponding timestamp
        switch ($newStatus) {
            case 'confirmed':
                $order->confirmed_at = $now;
                break;
            case 'washing':
                $order->washing_started_at = $now;
                break;
            case 'drying':
                $order->drying_started_at = $now;
                break;
            case 'ironing':
                $order->ironing_started_at = $now;
                break;
            case 'packaging':
                $order->packaging_started_at = $now;
                break;
            case 'completed':
                $order->completed_at = $now;
                break;
        }

        $order->status = $newStatus;
        $order->save();

        // Send notification to customer
        $order->customer->notify(new OrderStatusChanged($order));

        return back()->with('success', 'Order status updated successfully.');
    }
}