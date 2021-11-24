<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;

class SecuritySettingController extends Controller
{
    public function index()
    {
        return view('admin.security-settings.index')
            ->with('activeMenu', 'security-settings');
    }

    public function changePassword(Request $request)
    {
        if (app()->environment() === 'demo') {
            return redirect()->route('admin-dashboard')
                ->with('alert', 'warning')
                ->with('message', trans('lang.demo_mode'));
        }

        $rules = [
            'current_password' => 'required',
            'password' => 'min:6|confirmed'
        ];
        $this->validate($request, $rules);

        $user = User::find($request->user()->id);
        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => bcrypt($request->password)
            ]);

            return redirect()->back()
                ->with('alert', 'success')
                ->with('message', trans('lang.changes_saved'));
        }

        return redirect()->back()
            ->with('alert', 'danger')
            ->with('message', trans('lang.invalid_password'));
    }
}
