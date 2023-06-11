<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Users\UserCreateRequest;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserCreateController extends Controller
{

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function admin(UserCreateRequest $request): RedirectResponse
    {

        $type = 1;
        $terms = 1;
        $is_super = $request['is_super'];
        $email_verified_time = Carbon::now()->toDateTimeString();
        $rand = Str::random(36);

        if($request->validated())
        {
            User::create([
                'type' => $type,
                'is_super' => $is_super,
                'name' => $request['name'],
                'email' => $request['email'],
                'email_verified_at' => $email_verified_time,
                'password' => Hash::make($rand),
                'terms' => $terms
            ]);

            notyf()->addSuccess('Yeni yönetici başarılı bir şekilde oluşturuldu');
            return Redirect::route('panel.create.user');
        }

        return Redirect::back();
    }
}
