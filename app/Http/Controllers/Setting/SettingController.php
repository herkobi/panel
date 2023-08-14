<?php

namespace App\Http\Controllers\Setting;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Settings;
use App\Models\User;
use App\Utils\Helper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Kullanıcı ayarları
     *
     * Eğer aktifse görünür..
     */
    public function index()
    {
        if(!Helper::checkUserSettings()) {
            return to_route('panel.system.settings');
        } else {
            $user_settings = json_decode(Auth::user()->settings, true);
            return view('settings.app', [
                'user_settings' => $user_settings
            ]);
        }
    }

    /**
     * Kullanıcı bazlı ayarları güncelleme
     */
    public function user(Request $request): JsonResponse
    {
        if(!Helper::checkUserSettings()) {

            Log::warning( __('systemsettings.log.user.settings.policy.error') );

            return response()->json([
                'status' => 'error',
                'message' => __('systemsettings.user.settings.policy.error')
            ]);
        } else {
            if ($request->ajax() && $request->has('data')) {
                $user = User::findOrFail(Auth::user()->id);
                $settings = json_encode($request->data, JSON_UNESCAPED_SLASHES);
                $user->settings = $settings;
                $user->save();

                activity('admin')
                    ->performedOn($user) // kime yapıldı
                    ->causedBy(auth()->user()->id) // kim yaptı
                    ->event('update') // ne yaptı
                    ->withProperties(['title' => 'Kullanıcı Ayarlarını Güncelleme']) // işlem başlığı
                    ->log( __("systemsettings.user.settings.update.success", ['authuser' => auth()->user()->name])); // açıklama

                Log::info(
                    __("systemsettings.log.user.settings.update.success", [
                        'authuser' => auth()->user()->name,
                        'ip' => request()->ip()
                    ])
                );

                return response()->json(['status' => 'success']);
            }

            Log::warning( __("global.critical.error") );
            return response()->json(['status' => "error", "message" => __("global.critical.error")]);
        }
    }

    /**
     * Sistem Ayarları
     */
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

    /**
     * Sistem ayarları güncelleme
     */
    public function update(Request $request): JsonResponse
    {
        if ($request->ajax()) {
            foreach ($request->all() as $key => $value) {
                Settings::firstWhere('key', $key)->update([
                    'value' => $value
                ]);
            }

            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }
}
