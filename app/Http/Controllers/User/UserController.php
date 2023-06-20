<?php

namespace App\Http\Controllers\User;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Permissiongroup;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class UserController extends Controller
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

    public function index(): View
    {
        $users = User::where([['status', UserStatus::ACTIVE], ['type', UserType::USER]])->get();
        return view('users.index', compact('users'));
    }

    public function admins(): View
    {
        $users = User::where('type', UserType::ADMIN)->get()->except(User::role('Super Admin')->first()->id);
        return view('users.admins', compact('users'));
    }

    public function show(User $user): View
    {

        $role = Role::find($user->role->id);
        $basePermissions = array();
        $permissions = array();
        $permissions = Permission::withWhereHas('group', fn ($query) => $query->where('type', $role->type))->get();

        foreach ($permissions as $permission) {
            $basePermissions[$permission->group->name][$permission->id] = $permission->text;
        }

        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('users.detail', compact('user', 'role', 'basePermissions', 'rolePermissions'));
    }

    public function createAdmin(): View
    {
        $roles = Role::where([['type', UserType::ADMIN], ['name', '!=', 'Super Admin']])->get();
        return view('users.create', compact('roles'));
    }

    public function permissionAdmin(User $user): View
    {
        // $user = User::find($user->id);
        // $groups = Permissiongroup::where('type', UserType::ADMIN)->with('permission')->get();

        $role = Role::find($user->role->id);
        $basePermissions = array();
        $permissions = array();
        $permissions = Permission::withWhereHas('group', fn ($query) => $query->where('type', $role->type))->get();

        foreach ($permissions as $permission) {
            $basePermissions[$permission->group->name][$permission->id] = $permission->text;
        }

        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('users.adminpermissions', compact('user', 'groups', 'role', 'basePermissions', 'rolePermissions'));
    }

    public function editUser(User $user): View
    {
        return view('users.user-edit', compact('user'));
    }

    public function editAdmin(User $user): View
    {
        return view('user.admins-edit', compact('user'));
    }
}
