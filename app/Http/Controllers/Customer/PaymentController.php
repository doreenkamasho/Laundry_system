<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function process(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'phone_number' => 'required|string|regex:/^255[0-9]{9}$/',
            'amount' => 'required|numeric',
            'provider' => 'required|string|in:vodacom,airtel,halotel,mixx'
        ]);

        try {
            // Generate unique reference number
            $reference = strtoupper($validated['provider']) . time() . rand(1000, 9999);

            // Update booking status
            $booking->update([
                'payment_status' => 'paid',
                'status' => 'processing'
            ]);

            // Create transaction record
            $transaction = $booking->transaction()->create([
                'amount' => $validated['amount'],
                'phone_number' => $validated['phone_number'],
                'status' => 'completed',
                'payment_method' => $validated['provider'],
                'reference' => $reference, // Add the reference number
                'transaction_id' => $reference // Use same reference as transaction_id
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
}