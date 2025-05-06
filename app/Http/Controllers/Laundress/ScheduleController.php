<?php

namespace App\Http\Controllers\Laundress;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display the laundress schedule.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::with('schedule')->find(Auth::id());
        
        // If the user doesn't have a schedule yet, create a default one
        if (!$user->schedule) {
            $schedule = new Schedule();
            $schedule->user_id = $user->id;
            $schedule->working_days = [
                'monday' => ['is_available' => true, 'start_time' => '08:00', 'end_time' => '17:00'],
                'tuesday' => ['is_available' => true, 'start_time' => '08:00', 'end_time' => '17:00'],
                'wednesday' => ['is_available' => true, 'start_time' => '08:00', 'end_time' => '17:00'],
                'thursday' => ['is_available' => true, 'start_time' => '08:00', 'end_time' => '17:00'],
                'friday' => ['is_available' => true, 'start_time' => '08:00', 'end_time' => '17:00'],
                'saturday' => ['is_available' => false, 'start_time' => '08:00', 'end_time' => '17:00'],
                'sunday' => ['is_available' => false, 'start_time' => '08:00', 'end_time' => '17:00'],
            ];
            $schedule->is_available = true;
            $schedule->save();
            
            // Refresh user data
            $user = User::with('schedule')->find(Auth::id());
        }
        
        // Get upcoming bookings
        $upcomingBookings = $user->bookings()
            ->where('status', '!=', 'cancelled')
            ->where('scheduled_date', '>=', now()->format('Y-m-d'))
            ->orderBy('scheduled_date')
            ->orderBy('scheduled_time')
            ->get();
            
        return view('Laundress.schedule.index', compact('user', 'upcomingBookings'));
    }
    
    /**
     * Update the laundress schedule.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'working_days' => 'required|array',
            'working_days.*.is_available' => 'boolean',
            'working_days.*.start_time' => 'required_if:working_days.*.is_available,true|date_format:H:i',
            'working_days.*.end_time' => 'required_if:working_days.*.is_available,true|date_format:H:i|after:working_days.*.start_time',
        ]);
        
        $schedule = Schedule::firstOrNew(['user_id' => Auth::id()]);
        $schedule->working_days = $request->working_days;
        $schedule->save();
        
        return redirect()->route('laundress.schedule.index')
            ->with('success', 'Schedule updated successfully.');
    }
    
    /**
     * Update the laundress overall availability.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAvailability(Request $request)
    {
        $request->validate([
            'is_available' => 'required|boolean',
        ]);
        
        $schedule = Schedule::firstOrNew(['user_id' => Auth::id()]);
        $schedule->is_available = $request->is_available;
        $schedule->save();
        
        return redirect()->route('laundress.schedule.index')
            ->with('success', 'Availability status updated successfully.');
    }
}