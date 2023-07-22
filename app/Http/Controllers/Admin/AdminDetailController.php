<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;

class AdminDetailController extends Controller
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
     * Kullanıcı rolünü güncelleme
     * Ek rol tanımlama
     *
     * @param  array<string, string>  $input
     */
    public function updateRole(Request $request): RedirectResponse
    {
        $user = User::findOrFail($request->user);
        foreach ($request->role as $role) {
            $user->assignRole([$role]);
        }

        return Redirect::route('panel.admins');
    }

    public function passwordReset(User $user)
    {
        $status = Password::sendResetLink($user->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function changeEmail(Request $request, User $user)
    {
        if ($request->email !== $user->email && $user instanceof MustVerifyEmail) {
            $user->forceFill([ //forceFill'ler $user->email gibi değiştirelecek.
                'email' => $request->email,
                'email_verified_at' => null,
            ])->save();

            $user->sendEmailVerificationNotification();
            return redirect()->back();
        } else {
            return redirect()->back();
        }
    }

    public function verifyEmail(User $user)
    {
        /**
         * Burası direk işlem yapıyor. Bir kontrol yazılabilir.
         */
        $user->sendEmailVerificationNotification();
        return redirect()->back();
    }
}
