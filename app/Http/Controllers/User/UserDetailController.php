<?php

namespace App\Http\Controllers\User;

use App\Enums\Status;
use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserPermissionCreateRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Usertag;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Spatie\Activitylog\Models\Activity;

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
        $roles = Role::where('type', UserType::USER)->get();
        $tags = Usertag::where('status', Status::ACTIVE)->get();
        $selectedTag = $user->usertags->pluck('id')->toArray();
        $userCustomPermissions = $user->getAllPermissions()->pluck('id')->toArray();
        $activities = Activity::where('causer_id', $user->id)->get();

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
            'roles' => $roles,
            'selectedTag' => $selectedTag,
            'basePermissions' => $basePermissions,
            'rolePermissions' => $rolePermissions,
            'activities' => $activities
        ]);
    }

    /**
     * Kullanıcı durumunu güncelleme
     */
    public function status(Request $request, User $user)
    {
        if ($request->ajax()) {
            if($request->has('ids')) {
                foreach (UserStatus::cases() as $userStatus) {
                    if ($userStatus->value == $request->ids) {
                        $status = $userStatus->value;
                    }
                }

                $user->status = $status;
                $user->save();

                return response()->json(['status' => 'success']);
            }

            return response()->json([
                "status" => "error",
                "message" => __("usertag.update.user.status.error", [
                    'authuser' => auth()->user()->name,
                    'ip' => request()->ip(),
                    'name' => $request->name
                ])
            ]);
        }

        return response()->json(['status' => "error", "message" => __("global.critical.error")]);

    }

    /**
     * Kullanıcıya etiket atama
     */
    public function tags(Request $request, User $user)
    {
        if ($request->ajax() && $request->has('ids')) {

            $user->usertags()->sync($request->ids);

            return response()->json(['status' => 'success']);

        }

        return response()->json(['status' => "error", "message" => __("global.critical.error")]);

    }

    /**
     * Kullanıcı şifresini değiştirmesi için e-posta gönderimi
     *
     * @param  array<string, string>  $input
     */
    public function passwordReset(Request $request, User $user)
    {

        if ($request->ajax() && $request->has('ids')) {
            if($user->status === UserStatus::ACTIVE) {
                $status = Password::sendResetLink($user->only('email'));

                if ($status === Password::RESET_LINK_SENT) {

                    return response()->json(['status' => 'success']);

                } else {

                    return response()->json([
                        "status" => "error",
                        "message" => __("userdetail.reset.user.password.error", [
                            'authuser' => auth()->user()->name,
                            'ip' => request()->ip(),
                            'name' => $request->name
                        ])
                    ]);
                }
            }

            return response()->json([
                "status" => "error",
                "message" => __("userdetail.reset.user.password.status.error", [
                    'authuser' => auth()->user()->name,
                    'ip' => request()->ip(),
                    'name' => $request->name
                ])
            ]);
        }

        return response()->json(['status' => "error", "message" => __("global.critical.error")]);
    }

    /**
     * Kullanıcıya e-posta adresini değiştirmesi
     * için onay link gönderme
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

            return redirect()->back()->with('success', __('userdetail.change.user.email.success.message'));
        }

        return redirect()->back()->with('error', __('userdetail.change.user.email.error', ['authuser' => auth()->user()->name, 'name' => $user->name]));

    }

    /**
     * Kullanıcıya e-posta adresini onaylama linki gönderme
     *
     * @param  array<string, string>  $input
     */
    public function verifyEmail(Request $request, User $user)
    {

        if ($request->ajax() && $request->has('user_id')) {

            $status = $user->sendEmailVerificationNotification();
            return response()->json(['status' => 'success']);

        }

        return response()->json([
            "status" => "error",
            "message" => __("userdetail.verify.user.email.error", [
                'authuser' => auth()->user()->name,
                'ip' => request()->ip(),
                'name' => $request->name
            ])
        ]);

    }

    /**
     * Kullanıcı rolünü güncelleme
     * Ek rol tanımlama
     *
     * @param  array<string, string>  $input
     */
    public function updateRole(Request $request, User $user): RedirectResponse
    {
        if ($request->ajax() && $request->has('user_id')) {
            if(is_array($request->role)) {
                foreach ($request->role as $role) {
                    $user->assignRole([$role]);
                }

                return Redirect::route('panel.users')->with('success', __('user.update.user.role.success.message'));
            }

            return Redirect::route('panel.users')->with('error', __('user.update.user.role.empty.role.error'));
        }
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

            return Redirect::route('panel.users')->with('success', __('userdetail.give.user.permissions.success', ['authuser' => auth()->user()->name, 'name' => $user->name]));
        }

        return Redirect::back()->with('error', __('userdetail.give.user.permissions.error', ['authuser' => auth()->user()->name, 'name' => $user->name]));
    }
}
