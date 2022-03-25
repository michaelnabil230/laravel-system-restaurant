<?php

namespace App\Http\Controllers\Dashboard\Setting;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController
{
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required'],
            'logo' => ['sometimes', 'nullable', 'image'],
            'version' => ['required'],
        ]);

        if ($request->logo) {
            Storage::delete(setting('logo'));
            $validated['logo'] = $request->logo->store('public/logo');
        }
        setting($validated)->save();
        session()->flash('success', __('dashboard.added_successfully'));

        return to_route('dashboard.setting.index');
    }
}
