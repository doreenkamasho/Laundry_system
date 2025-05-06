<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    protected function authenticated(Request $request, $user)
    {
        if (!$user->role) {
            auth()->logout();
            return redirect()->route('login')
                ->withErrors(['email' => 'No role assigned to this user.']);
        }

        switch ($user->role->name) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'customer':
                return redirect()->route('customer.dashboard');
            case 'laundress':
                return redirect()->route('laundress.dashboard');
            default:
                return redirect()->route('root');
        }

        // Load user's theme settings into session
        session([
            'theme' => $user->theme_settings['theme'] ?? 'light',
            'layout-style' => $user->theme_settings['layout-style'] ?? 'default',
            'sidebar' => $user->theme_settings['sidebar'] ?? 'light',
            'sidebar-size' => $user->theme_settings['sidebar-size'] ?? 'lg',
            'sidebar-image' => $user->theme_settings['sidebar-image'] ?? 'none'
        ]);
    }

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
