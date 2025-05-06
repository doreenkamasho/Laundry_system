<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class SettingsController extends Controller
{
    public function general()
    {
        return view('admin.settings.general');
    }

    public function system()
    {
        return view('admin.settings.system');
    }

    public function updateGeneral(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
        ]);

        Setting::set('site_name', $request->site_name);
        Setting::set('contact_email', $request->contact_email);
        Setting::set('contact_phone', $request->contact_phone);

        return back()->with('success', 'General settings updated successfully');
    }

    public function updateSystem(Request $request)
    {
        $request->validate([
            'maintenance_mode' => 'boolean',
            'default_currency' => 'required|string|size:3',
            'timezone' => 'required|string',
        ]);

        Setting::set('maintenance_mode', $request->boolean('maintenance_mode'));
        Setting::set('default_currency', $request->default_currency);
        Setting::set('timezone', $request->timezone);

        return back()->with('success', 'System settings updated successfully');
    }
}
