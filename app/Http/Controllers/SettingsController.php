<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function show()
    {
        $setting = Setting::first();
        return response()->json($setting);
    }

    public function update(Request $request)
    {
        $request->validate([
            'default_currency' => 'required|string|size:3',
        ]);

        $setting = Setting::first();
        $setting->update($request->all());

        return response()->json($setting);
    }
}
