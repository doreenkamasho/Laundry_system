<?php

namespace App\Http\Controllers\Laundress;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\LaundressDetail;
use App\Models\User;

class LaundressSettingsController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $laundressDetail = LaundressDetail::where('user_id', $user->id)->first();
        return view('Laundress.settings.edit', compact('user', 'laundressDetail'));
    }

    public function update(Request $request)
    {
        $type = $request->input('type', 'profile');

        if ($type === 'password') {
            return $this->updatePassword($request);
        }

        return $this->updateProfile($request);
    }

    protected function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
        }

        // $user->password = Hash::make($request->password);
        // $user->save();

        return redirect()
            ->route('laundress.settings.edit')
            ->with('success', 'Password updated successfully');
    }

    protected function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'availability_status' => 'boolean',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric'
        ]);

        LaundressDetail::updateOrCreate(
            ['user_id' => $user->id],
            $request->only([
                'phone_number',
                'address',
                'availability_status',
                'latitude',
                'longitude'
            ])
        );

        return redirect()
            ->route('laundress.settings.edit')
            ->with('success', 'Profile settings updated successfully');
    }
}