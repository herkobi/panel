<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserPermissionCreateRequest;
use App\Models\User;
use App\Http\Requests\Users\UserCreateRequest;
use App\Models\Role;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminCreateController extends Controller
{

    /**
     * Yeni yönetici ekleme
     * @param  array<string, string>  $input
     */
    public function create(): View
    {
        $roles = Role::where([['type', UserType::ADMIN], ['name', '!=', 'Super Admin']])->get();
        return view('admins.create', compact('roles'));
    }

    /**
     * Yönetici ekleme işlemleri.
     *
     * @param  array<string, string>  $input
     */
    public function admin(UserCreateRequest $request): RedirectResponse
    {

        $type = UserType::ADMIN;
        $terms = 1;
        $email_verified_time = Carbon::now()->toDateTimeString();
        $rand = Str::random(36);
        $user_settings = Settings::whereNotIn('key', ['userrole', 'adminrole'])->pluck('value', 'key');
        $user_settings = json_encode($user_settings, JSON_UNESCAPED_SLASHES);

        if ($request->validated()) {
            $user = User::create([
                'type' => $type,
                'name' => $request['name'],
                'email' => $request['email'],
                'email_verified_at' => $email_verified_time,
                'password' => Hash::make($rand),
                'settings' => $user_settings,
                'created_by' => auth()->user()->id,
                'created_by_name' => auth()->user()->name,
                'terms' => $terms
            ]);

            foreach ($request->role as $role) {
                $user->assignRole([$role]);
            }

            return Redirect::route('panel.admins');
        }

        return Redirect::back()->with('Hata. Yönetici eklenirken bir hata oluştu.');
    }

}
