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

    public function show(User $user): View
    {
        //$permissiongroups = Permissiongroup::with('permission')->get();
        //$permissions = Permissiongroup::withWhereHas('permission', fn ($query) => $query->where('type', UserType::ADMIN))->get();

        $basePermissions = array();
        $permissions = array();

        foreach ($user->roles as $key => $role) {
            $permissions = Permission::withWhereHas('group', fn ($query) => $query->where('type', $role->type))->get();
            foreach ($permissions as $permission) {
                $basePermissions[$permission->group->name][$permission->id] = $permission->text;
            }

            $rolePermissions = $role->permissions->pluck('id')->toArray();
        }

        return view('users.detail', compact('user', 'basePermissions', 'rolePermissions'));
    }

    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }
}
