<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function processPayment(Request $request)
    {
        $validated = $request->validate([
            'phone_number' => 'required|string|regex:/^255[0-9]{9}$/',
            'amount' => 'required|numeric|min:1',
            'provider' => 'required|in:vodacom,airtel,halotel,mixx',
            'booking_data' => 'required|array'
        ]);

        try {
            DB::beginTransaction();

            // Create booking
            $bookingData = $validated['booking_data'];
            $booking = Booking::create([
                'customer_id' => auth()->id(),
                'laundress_id' => $bookingData['laundress_id'],
                'service_id' => $bookingData['service_id'],
                'scheduled_date' => $bookingData['scheduled_date'],
                'scheduled_time' => $bookingData['scheduled_time'],
                'pickup_required' => $bookingData['pickup_required'],
                'delivery_required' => $bookingData['delivery_required'],
                'pickup_fee' => $bookingData['pickup_fee'],
                'delivery_fee' => $bookingData['delivery_fee'],
                'total_amount' => $validated['amount'],
                'selected_items' => $bookingData['selected_items'],
                'status' => 'pending',
                'payment_status' => 'paid'
            ]);
            
            // Get or create wallet for the customer
            $wallet = auth()->user()->wallet ?? auth()->user()->createWallet();

            // Create transaction record
            $transaction = Transaction::create([
                'reference' => Transaction::generateReference(),
                'booking_id' => $booking->id,
                'wallet_id' => $wallet->id, // Add wallet_id
                'amount' => $validated['amount'],
                'type' => 'payment',
                'status' => 'completed',
                'provider' => $validated['provider'],
                'phone_number' => $validated['phone_number'],
                'description' => 'Payment for booking #' . $booking->id
            ]);

            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Payment processed successfully',
                'transaction' => $transaction->reference,
                'booking_id' => $booking->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Payment processing failed: ' . $e->getMessage()
            ], 500);
        }
    }
}