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
use Illuminate\View\View;

class SettingController extends Controller
{

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
     * Kullanıcı kendi ayarlarını güncelliyor
     */
    public function user(Request $request): JsonResponse
    {
        if(!Helper::checkUserSettings()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bu İşlemi gerçekleştiremezsiniz'
            ]);
        } else {
            if ($request->ajax() && $request->has('data')) {
                $user = User::findOrFail(Auth::user()->id);
                $settings = json_encode($request->data, JSON_UNESCAPED_SLASHES);
                $user->settings = $settings;
                $user->save();
                return response()->json(['status' => 'success']);
            }

            return response()->json(['error' => 'olmadı']);
        }
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
