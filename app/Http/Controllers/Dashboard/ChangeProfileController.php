<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UpdatePasswordRequest;
use App\Http\Requests\Dashboard\UpdateProfileRequest;

class ChangeProfileController extends Controller
{
    public function updatePassword(UpdatePasswordRequest $request)
    {
        auth()->user()->update($request->validated());

        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.profile.edit');
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        auth()->user()->update($request->validated());
        session()->flash('success', __('site.updated_successfully'));
        return redirect()->route('dashboard.profile.edit');
    }

    public function destroy()
    {
        $user = auth()->user();
        $user->update([
            'email' => time() . '_' . $user->email,
        ]);
        $user->delete();
        session()->flash('success', __('site.deleted_successfully'));
        return redirect()->route('admin.login');
    }
}
