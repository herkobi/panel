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
     * Kullanıcı türü super ya da admin ise /panel/admin
     * Kullanıcı türü user ya da demo ise /app url değerine yönlendirir.
     *
     * Kullanıcı aktifse normal ekranı pasifse /passive urlsine yönlendirir
     *
     * @param  $request
     * @return mixed
     */
    public function toResponse($request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            switch ($user->status) {
                case AccountStatus::ACTIVE:
                case AccountStatus::DRAFT:
                    $home = ($user->type == UserType::SUPER || $user->type == UserType::ADMIN) ? '/panel' : '/app';
                    break;
                case AccountStatus::PASSIVE:
                    $home = ($user->type == UserType::SUPER || $user->type == UserType::ADMIN) ? '/panel/passive' : '/app/passive';
                    break;
                case AccountStatus::DELETED:
                    Auth::logout();
                    return redirect('/login')->withErrors(['email' => 'Girmiş olduğunuz bilgilere ait kullanıcı bulunmamaktadır..']);
                default:
                    Auth::logout();
                    return redirect('/login')->withErrors(['email' => 'Girmiş olduğunuz bilgilere ait kullanıcı bulunmamaktadır.']);
            }

            return redirect()->intended($home);
        }

        return redirect('/login');
    }
}
