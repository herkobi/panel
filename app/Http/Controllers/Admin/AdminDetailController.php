<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

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

    public function changeEmail(Request $request, User $user)
    {
        if ($request->email !== $user->email && $user instanceof MustVerifyEmail) {
            $user->forceFill([
                'email' => $request->email,
                'email_verified_at' => null,
            ])->save();

            $user->sendEmailVerificationNotification();
            notyf()->addSuccess('E-posta adresi değiştirildi, onay linki tekrar gönderildi');
            return redirect()->back();
        } else {
            notyf()->addError('Hata; Lütfen daha sonra tekrar deneyiniz');
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
