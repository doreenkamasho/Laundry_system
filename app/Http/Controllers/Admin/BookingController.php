<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        
        $bookings = Booking::query()
            ->with(['customer', 'laundress', 'transaction'])  // Add transaction to eager loading
            ->when($status, function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->latest()
            ->paginate(10);
            
        $bookingCounts = [
            'all' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
        ];
        
        return view('admin.bookings.index', compact('bookings', 'bookingCounts'));
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,completed,cancelled'
        ]);

        $booking->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Booking status updated successfully');
    }
}
