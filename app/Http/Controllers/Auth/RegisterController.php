<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\Customer;
use App\Models\Role;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'avatar' => ['nullable', 'image' ,'mimes:jpg,jpeg,png,gif','max:2048'],
            'phone_number' => ['required', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();

        try {
            // Get customer role
            $customerRole = Role::where('name', 'customer')->first();

            if (!$customerRole) {
                throw new \Exception('Customer role not found');
            }

            // Create user with customer role
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role_id' => $customerRole->id,
                'is_active' => true
            ]);

            // Handle avatar upload
            if (request()->hasFile('avatar')) {
                $avatarPath = request()->file('avatar')->store('public/avatars');
                $user->avatar = str_replace('public/', '', $avatarPath);
                $user->save();
            }

            // Create customer profile
            Customer::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'phone_number' => $data['phone_number'],
                'address' => $data['address'],
                'avatar' => $user->avatar
            ]);

            DB::commit();

            event(new Registered($user));
            
            // Instead of logging in and redirecting to dashboard, 
            // redirect to login with success message
            return redirect()->route('login')
                ->with('success', 'Registration successful! Please login to continue.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Registration failed. Please try again.');
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:20',
            'address' => 'nullable|string',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // Get customer role
            $customerRole = Role::where('name', 'customer')->first();

            if (!$customerRole) {
                throw new \Exception('Customer role not found');
            }

            // Create user with customer role
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $customerRole->id,
                'is_active' => true
            ]);

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                $avatarPath = $request->file('avatar')->store('public/avatars');
                $user->avatar = str_replace('public/', '', $avatarPath);
                $user->save();
            }

            // Create customer profile
            Customer::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
                'avatar' => $user->avatar
            ]);

            DB::commit();

            // Fire registered event
            event(new Registered($user));

            // Redirect to login with success message
            return redirect()->route('login')
                ->with('success', 'Registration successful! Please login to continue.');

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Registration failed. Please try again.');
        }
    }
}
