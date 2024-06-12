<?php

namespace App\Http\Responses;

use App\Enums\AccountStatus;
use App\Enums\UserType;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * Kullanıcı türü ve durumuna göre yönlendirme
     *
     * Kullanıcı türü admin ise /panel/admin
     * Kullanıcı türü user ise /panel url değerine yönlendirir.
     *
     * Kullanıcı aktifse normal ekranı pasifse /passive urlsine yönlendirir
     *
     * @param  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        if (Auth::check() && Auth::user()->type == UserType::ADMIN) {
            $home = Auth::user()->status == AccountStatus::PASSIVE ? '/panel/passive' : '/panel';
        } else {
            $home = Auth::user()->status == AccountStatus::PASSIVE ? '/app/passive' : '/app';
        }

        return redirect()->intended($home);
    }
}
