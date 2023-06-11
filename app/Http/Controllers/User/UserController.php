<?php

namespace App\Http\Controllers\User;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
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
        $super_id = User::role('Super Admin')->first()->id;
        $users = User::where('type', UserType::ADMIN)->get()->except($super_id);
        $roles = Role::where('type', UserType::ADMIN)->get();
        return view('users.admins', compact('users'));
    }

    public function createAdmin(): View
    {
        $roles = Role::where('type', UserType::ADMIN)->where('name', '!=', 'Super Admin')->get();
        return view('users.create', compact('roles'));
    }
}
