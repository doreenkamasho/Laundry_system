<?php

namespace App\Http\Controllers\Laundress;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Booking;

class LaundressProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        
        // Get orders with completed transactions
        $stats = Booking::where('laundress_id', $user->id)
            ->whereHas('transaction', function($query) {
                $query->where('status', 'completed');
            })
            ->select(
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_amount) as total_earnings')
            )
            ->first();

        $totalOrders = $stats->total_orders ?? 0;
        $totalEarnings = $stats->total_earnings ?? 0;

        return view('Laundress.profile.show', compact('totalOrders', 'totalEarnings'));
    }

    public function edit()
    {
        return view('Laundress.profile.edit');
    }

    public function business()
    {
        return view('Laundress.profile.business');
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()
            ->route('laundress.profile.show')
            ->with('success', 'Profile updated successfully');
    }
}