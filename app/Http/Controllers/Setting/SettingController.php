<?php

namespace App\Http\Controllers\Setting;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\SettingsUpdateRequest;
use App\Models\Role;
use App\Models\Settings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(Request $request): View
    {
        $date_formats = ['F j, Y', 'Y-m-d', 'm/d/Y', 'd/m/Y'];
        $time_formats = ['g:i a', 'g:i A', 'H:i'];
        return view('settings.app', [
            'user' => $request->user(),
            'date_formats' => $date_formats,
            'time_formats' => $time_formats
        ]);
    }

    public function system(): View
    {
        $default_settings = Settings::pluck('value', 'key')->toArray();
        $default_settings = json_encode($default_settings, JSON_UNESCAPED_SLASHES);
        dd($default_settings);

        $user_roles = Role::where('type', UserType::USER)->get();
        $admin_roles = Role::where('type', UserType::ADMIN)->get()->except(Role::where('name', 'Super Admin')->first()->id);
        $date_formats = ['F j, Y', 'Y-m-d', 'm/d/Y', 'd/m/Y'];
        $time_formats = ['g:i a', 'g:i A', 'H:i'];
        return view('settings.system', [
            'default_settings' => $default_settings,
            'user_roles' => $user_roles,
            'admin_roles' => $admin_roles,
            'date_formats' => $date_formats,
            'time_formats' => $time_formats
        ]);
    }

    public function update(SettingsUpdateRequest $request, Settings $settings)
    {

        foreach ($request->except('_token') as $key => $value) {
            $settings->forceFill([
                'key' => $key,
                'value' => $value,
            ])->save();
        }

        return redirect()->back()->with('Sistem kayıtları başarılı bir şekilde güncellendi');
    }
}
