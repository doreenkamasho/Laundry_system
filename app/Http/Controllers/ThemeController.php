<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function update(Request $request)
    {
        $validSettings = [
            'theme' => 'data-bs-theme',
            'layoutStyle' => 'data-layout-style',
            'sidebar' => 'data-sidebar',
            'sidebarSize' => 'data-sidebar-size',
            'sidebarImage' => 'data-sidebar-image'
        ];
        
        $settings = auth()->user()->theme_settings;

        foreach ($validSettings as $key => $attr) {
            if ($request->has($key)) {
                $settings[$key] = $request->get($key);
                // Use user-specific session key
                session(['user_' . auth()->id() . '_' . $key => $request->get($key)]);
            }
        }

        auth()->user()->update([
            'theme_settings' => $settings
        ]);

        return response()->json(['success' => true]);
    }

    public function save(Request $request)
    {
        $settings = [
            'theme' => $request->input('data-bs-theme', 'light'),
            'layoutStyle' => $request->input('data-layout-style', 'default'),
            'sidebar' => $request->input('data-sidebar', 'light'),
            'sidebarSize' => $request->input('data-sidebar-size', 'lg'),
            'sidebarImage' => $request->input('data-sidebar-image', 'none')
        ];

        try {
            // Save to user's theme_settings
            auth()->user()->update([
                'theme_settings' => $settings
            ]);

            // Store in session with user-specific keys
            foreach ($settings as $key => $value) {
                session(['user_' . auth()->id() . '_' . $key => $value]);
            }

            // Redirect to the appropriate dashboard based on user role
            $dashboardRoute = auth()->user()->role->name . '.dashboard';
            
            return redirect()->route($dashboardRoute)
                ->with('success', 'Theme settings saved successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to save theme settings. Please try again.');
        }
    }
}