<?php

namespace App\Http\Responses;

use App\Enums\UserStatus;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class LoginResponse implements LoginResponseContract
{
    /**
     * @param  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        $home = auth()->user()->status == UserStatus::PASSIVE ? '/panel/passive' : '/panel';

        return redirect()->intended($home);
    }
}
