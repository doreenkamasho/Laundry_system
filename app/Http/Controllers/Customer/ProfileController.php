<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        return view('customer.profile.show');
    }

    public function edit()
    {
        return view('customer.profile.edit');
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        
        // Handle avatar upload separately
        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
            ]);

            try {
                // Delete old avatar if exists
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                
                // Store new avatar with unique name
                $fileName = 'avatar_' . $user->id . '_' . time() . '.' . $request->avatar->extension();
                $avatarPath = $request->file('avatar')->storeAs('avatars', $fileName, 'public');
                
                // Update user with new avatar path
                $user->update(['avatar' => $avatarPath]);

                // Log successful upload
                \Log::info('Avatar updated successfully', [
                    'user_id' => $user->id,
                    'path' => $avatarPath,
                    'full_url' => asset('storage/' . $avatarPath)
                ]);

                return redirect()->back()->with('success', 'Profile picture updated successfully');
            } catch (\Exception $e) {
                \Log::error('Avatar upload failed', [
                    'user_id' => $user->id,
                    'error' => $e->getMessage()
                ]);
                
                return redirect()->back()
                    ->with('error', 'Failed to upload profile picture. Please try again.')
                    ->withInput();
            }
        }

        // Handle other profile updates
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,'.$user->id,
            'phone' => 'nullable|string|size:9',
            'address' => 'nullable|string|max:255',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'address']));
        
        return redirect()->route('customer.profile')
            ->with('success', 'Profile updated successfully');
    }
}