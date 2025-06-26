<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\Wallet;
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
            'customer_id' => 'required|exists:users,id',
            'laundress_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'scheduled_date' => 'required|date',
            'scheduled_time' => 'required',
            'selected_items' => 'nullable|array',
            'pickup_required' => 'required|boolean',
            'delivery_required' => 'required|boolean',
            'pickup_fee' => 'nullable|numeric',
            'delivery_fee' => 'nullable|numeric',
            'total_amount' => 'required|numeric',
            'payment_status' => 'required|string',
            // ... other fields ...
        ]);

        $booking = Booking::create([
            'customer_id' => $validated['customer_id'],
            'laundress_id' => $validated['laundress_id'],
            'service_id' => $validated['service_id'],
            'scheduled_date' => $validated['scheduled_date'],
            'scheduled_time' => $validated['scheduled_time'],
            'selected_items' => $request->input('selected_items', []),
            'pickup_required' => $validated['pickup_required'],
            'delivery_required' => $validated['delivery_required'],
            'pickup_fee' => $validated['pickup_fee'] ?? 0,
            'delivery_fee' => $validated['delivery_fee'] ?? 0,
            'total_amount' => $validated['total_amount'],
            'payment_status' => $validated['payment_status'],
            // ... other fields ...
        ]);

        // If the request expects JSON (AJAX), return JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'booking_id' => $booking->id,
                'message' => 'Booking created successfully!'
            ]);
        }

        // Otherwise, fallback to redirect (for normal form posts)
        return redirect()->route('customer.bookings.index')->with('success', 'Booking created successfully!');
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

    public function processPayment(Request $request, Booking $booking)
    {
        // Validate the request
        $validated = $request->validate([
            'phone_number' => 'required|string|regex:/^255\d{9}$/',
            'amount' => 'required|numeric|min:1',
            'provider' => 'required|string|in:vodacom,airtel,halotel,mixx'
        ]);

        try {
            // Get or create customer wallet
            $wallet = Wallet::firstOrCreate(
                ['user_id' => auth()->id()],
                ['balance' => 0]
            );

            // Generate reference number
            $reference = Transaction::generateReference();

            // Update booking status
            $booking->update([
                'payment_status' => 'paid',
                'status' => 'processing'
            ]);

            // Create transaction record with wallet_id
            $transaction = Transaction::create([
                'reference' => $reference,
                'wallet_id' => $wallet->id, // Add wallet_id
                'booking_id' => $booking->id,
                'amount' => $validated['amount'],
                'type' => 'payment',
                'status' => 'completed',
                'payment_method' => 'mobile_money',
                'provider' => $validated['provider'],
                'phone_number' => $validated['phone_number'],
                'description' => 'Payment for booking #' . $booking->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment processed successfully',
                'transaction' => $reference
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment processing failed: ' . $e->getMessage()
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