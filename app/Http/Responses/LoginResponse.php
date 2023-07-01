<?php

namespace App\Http\Responses;

use App\Enums\UserStatus;
use App\Enums\UserType;
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
        if (auth()->user()->type == UserType::ADMIN) {
            $home = auth()->user()->status == UserStatus::PASSIVE ? '/panel/admin/passive' : '/panel/admin';
        } else {
            $home = auth()->user()->status == UserStatus::PASSIVE ? '/panel/passive' : '/panel';
        }

        return redirect()->intended($home);
    }
}
