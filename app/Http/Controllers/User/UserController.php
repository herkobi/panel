<?php

namespace App\Http\Controllers\User;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Permissiongroup;
use App\Models\Role;
use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::where('type', UserType::USER)->get();
        return view('users.index', compact('users'));
    }

    public function admins(): View
    {
        $users = User::where('type', UserType::ADMIN)->get()->except(User::role('Super Admin')->first()->id);
        return view('users.admins', compact('users'));
    }

    public function show(User $user): View
    {
        return view('users.detail', compact('user'));
    }

    public function createAdmin(): View
    {
        $roles = Role::where('type', UserType::ADMIN)->where('name', '!=', 'Super Admin')->get();
        return view('users.create', compact('roles'));
    }

    public function permissionAdmin(User $user): View
    {
        $user = User::find($user->id);
        $groups = Permissiongroup::where('type', UserType::ADMIN)->with('permission')->get();
        return view('users.adminpermissions', compact('user', 'groups'));
    }
}
