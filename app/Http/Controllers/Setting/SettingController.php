<?php

namespace App\Http\Controllers\Setting;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\SettingsUpdateRequest;
use App\Models\Role;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $user_settings = json_decode(Auth::user()->settings, true);
        return view('settings.app', [
            'user_settings' => $user_settings
        ]);
    }

    public function system(): View
    {
        $default_settings = Settings::pluck('value', 'key')->toArray();
        $user_roles = Role::where('type', UserType::USER)->get();
        $admin_roles = Role::where('type', UserType::ADMIN)->get()->except(Role::where('name', 'Super Admin')->first()->id);
        return view('settings.system', [
            'default_settings' => $default_settings,
            'user_roles' => $user_roles,
            'admin_roles' => $admin_roles
        ]);
    }

    public function update(SettingsUpdateRequest $request): RedirectResponse
    {
        foreach ($request->except('_token') as $key => $value) {
            Settings::firstWhere('key', $key)->update([
                'value' => $value
            ]);
        }
        return redirect()->back()->with('Sistem kayıtları başarılı bir şekilde güncellendi');
    }
}
