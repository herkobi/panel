<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserPermissionCreateRequest;
use App\Models\Permission;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class AdminDetailController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('throttle:6,1')->only('verifyEmail');
    }

    /**
     * Yönetici detay sayfası
     */
    public function show(User $user): View
    {
        $basePermissions = array();
        $permissions = array();

        $userCustomPermissions = $user->getAllPermissions()->pluck('id')->toArray();

        foreach ($user->roles as $key => $role) {
            $permissions = Permission::withWhereHas('group', fn ($query) => $query->where('type', $role->type))->get();
            foreach ($permissions as $permission) {
                $basePermissions[$permission->group->name][$permission->id] = $permission->text;
            }

            $rolePermissions = $role->permissions->pluck('id')->toArray();
        }

        $rolePermissions = !empty($userCustomPermissions) ? array_merge($rolePermissions, $userCustomPermissions) : $rolePermissions;

        return view('admins.detail', [
            'user' => $user,
            'basePermissions' => $basePermissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Kullanıcı durumunu güncelleme
     */
    public function status(Request $request, User $user)
    {
        $ip = request()->ip();
        $authuser = auth()->user()->name;

        if ($request->ajax() && $request->has('ids')) {
            foreach (UserStatus::cases() as $userStatus) {
                if ($userStatus->value == $request->ids) {
                    $status = $userStatus->value;
                }
            }

            $user->status = $status;
            $user->save();

            $statusname = UserStatus::getTitle($status);

            activity()->log($authuser. ', '.$user->name. ' durumunu '. $statusname .' olarak değiştirdi');
            Log::info("{$authuser}, {$ip} ip adresi üzerinden, {$user->name} isimli kullanıcının durumunu {$statusname} olarak güncelledi");

            return response()->json(['status' => 'success']);
        }

        Log::error("{$authuser}, {$ip} ip adresi üzerinden, {$user->name} isimli kullanıcının durumunu güncellerken bir hata oluştu");

        return response()->json(['status' => 'error']);

    }

    /**
     * Kullanıcı şifresini değiştirmesi için e-posta gönderimi
     *
     * @param  array<string, string>  $input
     */
    public function passwordReset(Request $request, User $user)
    {
        $ip = request()->ip();
        $authuser = auth()->user()->name;

        if ($request->ajax() && $request->has('user_id')) {
            if($user->status == UserStatus::ACTIVE) {
                $status = Password::sendResetLink($user->only('email'));

                if ($status === Password::RESET_LINK_SENT) {

                    activity()->log($authuser. ', '.$user->name. ' isimli kullanıcıya şifre yenileme linki gönderdi');
                    Log::info("{$authuser}, {$ip} ip adresi üzerinden, {$user->name} isimli kullanıcıya şifre yenileme linki gönderdi");

                    return response()->json(['status' => 'success']);

                } else {

                    Log::error("{$authuser}, {$ip} ip adresi üzerinden, {$user->name} isimli kullanıcıya şifre yenileme linki gönderirken bir sorun oluştu");

                    return response()->json(['status' => 'error']);
                }
            }

            Log::error("{$authuser}, {$ip} ip adresi üzerinden, {$user->name} isimli kullanıcıya gönderilen şifre yenileme linki kullanıcının durumu Aktif olmadığı için gönderilmedi");

            return response()->json(['status' => 'error', 'message' => 'Kullanıcı durumu aktif değil, şifre yenileme linki gönderemezsiniz.']);
        }
    }

    /**
     * Kullanıcıya e-posta adresini onaylaması
     * için link gönderme
     *
     * @param  array<string, string>  $input
     */
    public function changeEmail(Request $request, User $user)
    {

        $ip = request()->ip();
        $authuser = auth()->user()->name;

        if ($request->email !== $user->email && $user instanceof MustVerifyEmail) {
            $user->email = $request->email;
            $user->email_verified_at = null;
            $user->save();

            $user->sendEmailVerificationNotification();

            activity()->log($authuser. ', '.$user->name. ' isimli kullanıcının e-posta adresini değiştirdi.');
            Log::info("{$authuser}, {$ip} ip adresi üzerinden, {$user->name} isimli kullanıcının e-posta adresini değiştirdi. Kullanıcının yeni e-posta adresine onay linki gönderildi");

            return redirect()->back()->with('success', 'Kullanıcı e-posta adresi değiştirilmiş ve onay linki gönderilmiştir.');
        }

        Log::error("{$authuser}, {$ip} ip adresi üzerinden, {$user->name} isimli kullanıcının e-posta adresini değiştirirken bir sorun oluştu");

        return redirect()->back()->with('error', 'Hata; Lütfen daha sonra tekrar deneyiniz');

    }

    /**
     * Kullanıcıya e-posta adresini onaylama linki gönderme
     *
     * @param  array<string, string>  $input
     */
    public function verifyEmail(Request $request, User $user)
    {

        $ip = request()->ip();
        $authuser = auth()->user()->name;

        if ($request->ajax() && $request->has('user_id')) {

            $status = $user->sendEmailVerificationNotification();

            activity()->log($authuser. ', '.$user->name. ' isimli kullanıcının e-posta adresini onaylaması için link gönderdi.');
            Log::info("{$authuser}, {$ip} ip adresi üzerinden, {$user->name} isimli kullanıcının e-posta adresini onaylaması için link gönderdi.");

            return response()->json(['status' => 'success']);

        }

        Log::error("{$authuser}, {$ip} ip adresi üzerinden, {$user->name} isimli kullanıcının e-posta adresini onaylaması için link gönderirken bir sorun ile karşılaştı.");

        return response()->json(['status' => 'error']);

    }

    /**
     * Yönetici Özel izinler sayfası
     */
    public function permissions(User $user): View
    {
        $basePermissions = array();
        $permissions = array();
        $rolePermissions = array();

        $permissions = Permission::withWhereHas('group', fn ($query) => $query->where('type', UserType::ADMIN))->get();

        foreach ($permissions as $permission) {
            $basePermissions[$permission->group->name][$permission->id] = [
                'title' => $permission->text,
                'name' => $permission->name
            ];
        }

        $userCustomPermissions = $user->getAllPermissions()->pluck('id')->toArray();

        foreach ($user->roles as $role) {
            $rolePermissions = $role->permissions->pluck('id')->toArray();
        }

        $rolePermissions = !empty($userCustomPermissions) ? array_merge($rolePermissions, $userCustomPermissions) : $rolePermissions;

        return view('admins.permissions', [
            'user' => $user,
            'basePermissions' => $basePermissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Yöneticiye özel izinler atama.
     *
     * @param  array<string, string>  $input
     */
    public function givePermissions(UserPermissionCreateRequest $request, User $user): RedirectResponse
    {
        if ($request->validated()) {
            foreach ($request->permission as $permission) {
                $user->givePermissionTo($permission);
            }

            return Redirect::route('panel.admins');
        }

        return Redirect::back()->with('Hata. Yönetici eklenirken bir hata oluştu.');
    }
}
