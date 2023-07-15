<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Yöneticileri listeleme sayfası
     */
    public function index(): View
    {
        /**
         * Super Admin rolü dışında yöneticiler için tanımlanmış rollere ait kullanıcılar çekiliyor.
         */
        $users = User::where('type', UserType::ADMIN)->get()->except(User::role('Super Admin')->first()->id);
        $roles = Role::where('type', UserType::ADMIN)->get()->except(Role::where('name', 'Super Admin')->first()->id);
        return view('admins.index', ['users' => $users, 'roles' => $roles]);
    }

    /**
     * Yönetici detay sayfası
     */
    public function show(User $user): View
    {
        $basePermissions = array();
        $permissions = array();

        foreach ($user->roles as $key => $role) {
            $permissions = Permission::withWhereHas('group', fn ($query) => $query->where('type', $role->type))->get();
            foreach ($permissions as $permission) {
                $basePermissions[$permission->group->name][$permission->id] = $permission->text;
            }

            $rolePermissions = $role->permissions->pluck('id')->toArray();
        }

        return view('admins.detail', [
            'user' => $user,
            'basePermissions' => $basePermissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function create(): View
    {
        $roles = Role::where([['type', UserType::ADMIN], ['name', '!=', 'Super Admin']])->get();
        return view('admins.create', compact('roles'));
    }

    public function permissions(User $user): View
    {
        $userRoles = array();
        $basePermissions = array();
        $permissions = array();
        $rolePermissions = array();

        $permissions = Permission::withWhereHas('group', fn ($query) => $query->where('type', UserType::ADMIN))->get();

        foreach ($permissions as $permission) {
            $basePermissions[$permission->group->name][$permission->id] = $permission->text;
        }

        foreach ($user->roles as $role) {
            $rolePermissions = $role->permissions->pluck('id')->toArray();
        }

        return view('admins.permissions', compact('user', 'basePermissions', 'rolePermissions'));
    }

    public function status(Request $request)
    {
        if ($request->ajax() && $request->has('ids')) {
            $user = User::findOrFail($request->user_id);
            foreach (UserStatus::cases() as $userStatus) {
                if ($userStatus->value == $request->ids) {
                    $status = $userStatus->value;
                }
            }

            $user->forceFill([
                'status' => $status
            ])->save();
        }
    }

    public function filter(Request $request)
    {
        if ($request->has('statusIds')) {
            return response()->json([
                'users' => User::paginate('25'),
            ]);
        }
        //$users = User::where('type', [UserType::USER])->with('usertags')->get();
    }

    /**
     * Yöneticiler sayfasındaki arama formu
     */
    public function search(Request $request)
    {
        $data = User::select('name', 'email')
            ->where("name", "LIKE", "%{$request->str}%")
            ->oRwhere("email", "LIKE", "%{$request->str}%")
            ->get('query');
        return response()->json($data);
    }
}
