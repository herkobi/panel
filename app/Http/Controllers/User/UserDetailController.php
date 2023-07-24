<?php

namespace App\Http\Controllers\User;

use App\Enums\Status;
use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserPermissionCreateRequest;
use App\Models\Permission;
use App\Models\Usertag;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class UserDetailController extends Controller
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
     * Kullanıcı Detay Sayfası
     */
    public function show(User $user): View
    {
        $basePermissions = array();
        $permissions = array();
        $tags = Usertag::where('status', Status::ACTIVE)->get();
        $selectedTag = $user->usertags->pluck('id')->toArray();
        $userCustomPermissions = $user->getAllPermissions()->pluck('id')->toArray();

        foreach ($user->roles as $key => $role) {
            $permissions = Permission::withWhereHas('group', fn ($query) => $query->where('type', $role->type))->get();
            foreach ($permissions as $permission) {
                $basePermissions[$permission->group->name][$permission->id] = $permission->text;
            }

            $rolePermissions = $role->permissions->pluck('id')->toArray();
        }

        $rolePermissions = !empty($userCustomPermissions) ? array_merge($rolePermissions, $userCustomPermissions) : $rolePermissions;

        return view('users.detail', [
            'user' => $user,
            'tags' => $tags,
            'selectedTag' => $selectedTag,
            'basePermissions' => $basePermissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Kullanıcı durumunu güncelleme
     */
    public function status(Request $request)
    {
        if ($request->ajax() && $request->has('ids')) {
            $user = User::findOrFail($request->user_id);
            foreach (UserStatus::cases() as $userStatus) {
                if ($userStatus->value == $request->ids) {
                    $status = $userStatus->value;
                }
            }

            $user->status = $status;
            $user->save();

            return response()->json(['status' => 'success']);
        }
    }

    /**
     * Kullanıcı şifresini değiştirmesi için e-posta gönderimi
     *
     * @param  array<string, string>  $input
     */
    public function passwordReset(User $user)
    {
        $status = Password::sendResetLink($user->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return redirect()->back();
        } else {
            return redirect()->back()->with($status);
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
        if ($request->email !== $user->email && $user instanceof MustVerifyEmail) {
            $user->email = $request->email;
            $user->email_verified_at = null;
            $user->save();

            $user->sendEmailVerificationNotification();
            return redirect()->back();
        } else {
            return redirect()->back()->with('Hata; Lütfen daha sonra tekrar deneyiniz');
        }
    }

    /**
     * Kullanıcıya e-posta adresini onaylama linki gönderme
     *
     * @param  array<string, string>  $input
     */
    public function verifyEmail(User $user)
    {
        $user->sendEmailVerificationNotification();
        return redirect()->back();
    }

    /**
     * Kullanıcı özel izin tanımlama
     */
    public function permissions(User $user): View
    {
        $basePermissions = array();
        $permissions = array();
        $rolePermissions = array();

        $permissions = Permission::withWhereHas('group', fn ($query) => $query->where('type', UserType::USER))->get();

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

        return view('users.permissions', [
            'user' => $user,
            'basePermissions' => $basePermissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    /**
     * Kullanıcıya özel izin atama
     *
     * @param  array<string, string>  $input
     */
    public function givePermissions(UserPermissionCreateRequest $request, User $user): RedirectResponse
    {
        if ($request->validated()) {
            foreach ($request->permission as $permission) {
                $user->givePermissionTo($permission);
            }

            return Redirect::route('panel.users');
        }

        return Redirect::back()->with('Hata. Yönetici eklenirken bir hata oluştu.');
    }

    /**
     * Kullanıcılara etiket atama
     */
    public function tags(Request $request)
    {
        if ($request->ajax() && $request->has('ids')) {
            $user = User::findOrFail($request->user_id);

            //$user->usertags()->detach();
            foreach ($request->ids as $tagId) {
                $user->usertags()->toggle($tagId);
            }
        }
    }
}
