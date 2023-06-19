<?php

namespace App\Http\Controllers\User;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Permissiongroup;
use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
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
        return view('users.detail', compact('user'));
    }

    public function createAdmin(): View
    {
        $roles = Role::where([['type', UserType::ADMIN], ['name', '!=', 'Super Admin']])->get();
        return view('users.create', compact('roles'));
    }

    public function permissionAdmin(User $user): View
    {
        $user = User::find($user->id);
        $groups = Permissiongroup::where('type', UserType::ADMIN)->with('permission')->get();
        return view('users.adminpermissions', compact('user', 'groups'));
    }

    public function editUser(User $user): View
    {
        return view('users.user-edit', compact('user'));
    }

    public function editAdmin(User $user): View
    {
        return view('user.admins-edit', compact('user'));
    }

    public function passwordReset(User $user)
    {
        $status = Password::sendResetLink($user->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            notyf()->addSuccess('Şifre yenilime linki e-posta adresine gönderildi');
            return redirect()->back();
        } else {
            notyf()->addError($status);
            return redirect()->back();
        }
    }

    public function verifyEmail(User $user)
    {
        $user->sendEmailVerificationNotification();
        notyf()->addSuccess('E-posta onay linki tekrar gönderildi');
        return redirect()->back();
    }
}
