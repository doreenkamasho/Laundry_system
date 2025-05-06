<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoadUserThemeSettings
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $settings = auth()->user()->theme_settings;
            
            // Load user-specific theme settings into session
            foreach ($settings as $key => $value) {
                session(['user_' . auth()->id() . '_' . $key => $value]);
            }
        }

        return $next($request);
    }
}