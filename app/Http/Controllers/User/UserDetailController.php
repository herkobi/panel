<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserPermissionCreateRequest;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;

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


    public function userModelData(Request $request): JsonResponse
    {
        if ($request->ajax() && $request->has('ids')) {
            $user = User::where('id', $request->ids)->with('roles')->get();
            return response()->json([
                'user_data' => $user
            ]);
        }
    }

    public function updateRole(Request $request): RedirectResponse
    {
        $user = User::findOrFail($request->user);
        foreach ($request->role as $role) {
            $user->assignRole([$role]);
        }

        return Redirect::route('panel.users');
    }

    public function passwordReset(User $user)
    {
        $status = Password::sendResetLink($user->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return redirect()->back();
        } else {
            return redirect()->back()->with($status);
        }
    }

    public function changeEmail(Request $request, User $user)
    {
        if ($request->email !== $user->email && $user instanceof MustVerifyEmail) {
            $user->forceFill([
                'email' => $request->email,
                'email_verified_at' => null,
            ])->save();

            $user->sendEmailVerificationNotification();
            return redirect()->back();
        } else {
            return redirect()->back()->with('Hata; Lütfen daha sonra tekrar deneyiniz');
        }
    }

    public function verifyEmail(User $user)
    {
        $user->sendEmailVerificationNotification();
        return redirect()->back();
    }

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function permissions(UserPermissionCreateRequest $request, User $user): RedirectResponse
    {
        if ($request->validated()) {
            foreach ($request->permission as $permission) {
                $user->givePermissionTo([$permission]);
            }

            return Redirect::route('panel.users');
        }

        return Redirect::back()->with('Hata. Yönetici eklenirken bir hata oluştu.');
    }
}

// TODO: Ek rol tanımlarken kullanıcı bilgisi kontrol edilecek
