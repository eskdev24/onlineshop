<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');

        // Ensure checkboxes that are not present are set to 0
        if (! $request->has('maintenance_mode')) {
            $data['maintenance_mode'] = '0';
        }

        foreach ($data as $key => $value) {
            \App\Models\Setting::set($key, $value);
        }

        \Illuminate\Support\Facades\Cache::forget('buyvia_site_settings');

        if (app()->environment('production')) {
            \Illuminate\Support\Facades\Artisan::call('config:clear');
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
