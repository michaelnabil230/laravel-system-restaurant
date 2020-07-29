<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Jobs\SendNotify;
use App\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:super_admin');
    }

    public function index()
    {
        $setting = Setting::first();
        return view('dashboard.setting.index', compact('setting'));
    }

    public function post(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'value_added' => 'required',
        ]);

        $request_data = $request->all();

        if ($request->logo) {
            $request_data['logo'] = $request->logo->store('public/logo');
        }

        Setting::first()->update($request_data);

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.setting.index');

    }//end of update
}
