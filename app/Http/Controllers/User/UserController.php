<?php

namespace App\Http\Controllers\User;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
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
        $users = User::where('type', UserType::ADMIN)->get();
        return view('users.admins', compact('users'));
    }

    public function createAdmin(): View
    {
        return view('users.create');
    }
}
