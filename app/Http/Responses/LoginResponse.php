<?php

namespace App\Http\Responses;

use App\Enums\UserStatus;
use App\Enums\UserType;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
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
