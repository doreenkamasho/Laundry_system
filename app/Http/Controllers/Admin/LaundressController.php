<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\LaundressDetail;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class LaundressController extends Controller
{
    private function handleAvatarUpload($file)
    {
        try {
            // Generate unique filename
            $filename = 'laundress_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            // Store in the public disk under avatars directory
            $path = $file->storeAs('avatars', $filename, 'public');
            
            \Log::info('Avatar uploaded:', ['path' => $path]);
            
            return $path;
        } catch (\Exception $e) {
            \Log::error('Avatar upload failed:', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    private function deleteOldAvatar($avatarPath)
    {
        if ($avatarPath && Storage::disk('public')->exists($avatarPath)) {
            Storage::disk('public')->delete($avatarPath);
        }
    }

    private function verifyAvatar($avatarPath)
    {
        if (!$avatarPath) {
            return false;
        }

        $exists = Storage::disk('public')->exists($avatarPath);
        \Log::info('Avatar verification:', [
            'path' => $avatarPath,
            'exists' => $exists,
            'full_path' => Storage::disk('public')->path($avatarPath)
        ]);

        return $exists;
    }

    public function index(Request $request)
    {
        $query = User::whereHas('role', function($q) {
            $q->where('name', 'laundress');
        })->with('laundressDetail');

        // Handle search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Handle status filter
        if ($request->has('status')) {
            $status = $request->status === 'active';
            $query->where('is_active', $status);
        }

        $laundresses = $query->latest()->paginate(10);
        return view('admin.users.laundress.index', compact('laundresses'));
    }

    public function create()
    {
        return view('admin.users.laundress.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            // User table fields
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'theme_settings' => 'nullable|array',
            
            // LaundressDetail table fields
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'current_location' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'availability_status' => 'nullable|boolean'
        ]);

        DB::beginTransaction();
        try {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => Role::where('name', 'laundress')->first()->id,
                'is_active' => $request->has('is_active')
            ];

            // Handle avatar upload with consistent approach
            if ($request->hasFile('avatar')) {
                $userData['avatar'] = $this->handleAvatarUpload($request->file('avatar'));
            }

            $user = User::create($userData);

            LaundressDetail::create([
                'user_id' => $user->id,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'availability_status' => $request->availability_status ?? true,
                'current_location' => $request->current_location ?? $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);

            DB::commit();
            return redirect()->route('admin.laundress.index')
                ->with('success', 'Laundress added successfully');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Failed to add laundress: ' . $e->getMessage())->withInput();
        }
    }

    public function show(User $laundress)
    {
        $laundress->load('laundressDetail');
        return view('admin.users.laundress.show', compact('laundress'));
    }

    public function edit(User $laundress)
    {
        $laundress->load('laundressDetail');
        return view('admin.users.laundress.edit', compact('laundress'));
    }

    public function update(Request $request, User $laundress)
    {
        $request->validate([
            // User table fields
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $laundress->id,
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'theme_settings' => 'nullable|array',
            
            // LaundressDetail table fields
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string',
            'current_location' => 'nullable|string',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'availability_status' => 'nullable|boolean'
        ]);

        DB::beginTransaction();

        try {
            // Update user data
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'theme_settings' => $request->theme_settings
            ];

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete old avatar
                $this->deleteOldAvatar($laundress->avatar);
                
                // Upload new avatar
                $userData['avatar'] = $this->handleAvatarUpload($request->file('avatar'));
            }

            $laundress->update($userData);

            // Update laundress details
            $laundress->laundressDetail->update([
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'avatar' => $userData['avatar'] ?? $laundress->avatar,
                'availability_status' => $request->availability_status,
                'current_location' => $request->current_location ?? $request->address,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);

            DB::commit();

            return redirect()->route('admin.laundress.index')
                ->with('success', 'Laundress updated successfully');

        } catch (\Exception $e) {
            DB::rollback();
            return back()
                ->with('error', 'Failed to update laundress: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(User $laundress)
    {
        try {
            DB::beginTransaction();
            
            // Delete avatar if exists
            $this->deleteOldAvatar($laundress->avatar);
            
            // Delete laundress details first
            $laundress->laundressDetail()->delete();
            
            // Then delete user
            $laundress->delete();
            
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Laundress deleted successfully'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete laundress: ' . $e->getMessage()
            ], 500);
        }
    }

    public function toggleStatus(User $laundress)
    {
        try {
            $laundress->update(['is_active' => !$laundress->is_active]);

            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    }
}