<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create(Request $request, $laundress)
    {
        $laundress = User::with(['services' => function($query) {
            $query->activeCategoryOnly();
        }, 'schedule'])->findOrFail($laundress);

        // Group services by category_name
        $servicesByCategory = $laundress->services->groupBy('category_name');
        
        // Get available days from schedule
        $availableDays = collect($laundress->schedule->working_days)
            ->filter(function ($day) {
                return $day['is_available'];
            })
            ->keys()
            ->toArray();

        return view('Customer.bookings.create', [
            'laundress' => $laundress,
            'servicesByCategory' => $servicesByCategory,
            'availableDays' => $availableDays,
            'delivery_fee' => 3500.00,
            'pickup_fee' => 3500.00
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'required|date_format:H:i'
        ]);

        $booking = new Booking();
        $booking->scheduled_date = Carbon::parse($validated['scheduled_date']);
        $booking->scheduled_time = Carbon::parse($validated['scheduled_time']);
        // ...other fields...
        $booking->save();
    }

    public function calculateTotal(Request $request)
    {
        $services = $request->input('services', []);
        $pickup = $request->boolean('pickup_required');
        $delivery = $request->boolean('delivery_required');
        
        $total = 0;
        
        // Calculate services total
        foreach ($services as $serviceId => $quantity) {
            $service = Service::find($serviceId);
            if ($service) {
                $total += $service->price * $quantity;
            }
        }
        
        // Add delivery fees
        if ($pickup) $total += 3500;
        if ($delivery) $total += 3500;
        
        return response()->json([
            'total' => $total,
            'formatted_total' => 'Tsh ' . number_format($total, 2)
        ]);
    }

    public function payment()
    {
        return view('Customer.bookings.payment');
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        // Make sure the booking belongs to the authenticated user
        if ($booking->customer_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('Customer.bookings.show', compact('booking'));
    }

    public function processPayment(Request $request)
    {
        try {
            $validated = $request->validate([
                'phone_number' => 'required|string|regex:/^255[0-9]{9}$/',
                'amount' => 'required|numeric|min:1',
                'provider' => 'required|in:vodacom,airtel,halotel,mixx',
                'booking_id' => 'required|exists:bookings,id'
            ]);

            // Simulate payment processing
            $success = rand(0, 10) > 2; // 80% success rate for demo
            
            if (!$success) {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment failed. Please try again.'
                ], 422);
            }

            // Create transaction record
            $transaction = Transaction::create([
                'reference' => 'TXN-' . strtoupper(uniqid()),
                'amount' => $validated['amount'],
                'provider' => $validated['provider'],
                'status' => 'completed',
                'phone_number' => $validated['phone_number'],
                'booking_id' => $validated['booking_id']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment processed successfully',
                'transaction' => $transaction->reference
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    public function index(Request $request)
    {
        $user = auth()->user();
        $status = $request->get('status');

        // Query base
        $query = Booking::where('customer_id', $user->id);

        // Filter by status if provided
        if ($status) {
            $query->where('status', $status);
        }

        // Get bookings with eager loading
        $bookings = $query->with(['service', 'laundress'])
                         ->latest()
                         ->paginate(10);

        // Get counts for sidebar using a single query
        $statusCounts = Booking::where('customer_id', $user->id)
            ->selectRaw('status, count(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $bookingCounts = [
            'all' => array_sum($statusCounts),
            'pending' => $statusCounts['pending'] ?? 0,
            'confirmed' => $statusCounts['confirmed'] ?? 0,
            'completed' => $statusCounts['completed'] ?? 0
        ];

        return view('Customer.bookings.index', compact('bookings', 'bookingCounts'));
    }

    public function cancel(Booking $booking)
    {
        // Check if user owns this booking
        if ($booking->customer_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if booking can be cancelled
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be cancelled.');
        }

        try {
            // Update booking status
            $booking->update([
                'status' => 'cancelled'
            ]);

            return back()->with('success', 'Booking cancelled successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Could not cancel booking. Please try again.');
        }
    }
}