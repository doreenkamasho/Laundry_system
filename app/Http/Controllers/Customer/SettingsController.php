<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Events\CustomerPasswordChanged;

class SettingsController extends Controller
{
    public function edit()
    {
        return view('customer.settings.edit');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'min:8', 'different:current_password'],
        ], [
            'current_password.current_password' => 'The current password is incorrect.',
            'password.different' => 'The new password must be different from your current password.',
        ]);

        $user = auth()->user();
        
        // Update password
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        // Send notification to admin
        event(new CustomerPasswordChanged($user));

        return redirect()
            ->route('customer.settings')
            ->with('success', 'Password updated successfully! You may need to login again with your new password.');
    }
}