<?php

namespace App\Http\Controllers\Dashboard\Setting;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $settings = Setting::when($request->search, function ($query) use ($request) {
            return $query->where('key', 'like', '%' . $request->search . '%');
        })->latest('id')->paginate();

        return view('dashboard.setting.settings.index', compact('settings'));
    } //end of index

    public function create()
    {
        return view('dashboard.setting.settings.create');
    } //end of create

    public function store(Request $request)
    {
        $request_data = $request->validate([
            'key' => 'required',
            'value' => 'required',
        ]);
        Setting::create($request_data);
        session()->flash('success', __('site.added_successfully'));
        return redirect()->route('dashboard.settings.index');
    } //end of store

    public function edit(Setting $setting)
    {
        return view('dashboard.setting.settings.edit', compact('setting'));
    } //end of edit

    public function update(Request $request, Setting $setting)
    {
        $request_data = $request->validate([
            'key' => 'required',
            'value' => 'required',
        ]);
        $setting->update($request_data);
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.settings.index');
    } //end of update
    public function destroy(Setting $setting)
    {
        $setting->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('dashboard.settings.index');
    } //end of destroy
}
