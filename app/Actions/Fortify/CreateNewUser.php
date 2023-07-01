<?php

namespace App\Actions\Fortify;

use App\Models\Settings;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        $type = 2;
        $terms = 1;

        $user_settings = Settings::whereNotIn('key', ['userrole', 'adminrole'])->pluck('value', 'key');
        $user_settings = json_encode($user_settings, JSON_UNESCAPED_SLASHES);

        $user = User::create([
            'type' => $type,
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'terms' => $terms,
            'settings' => $user_settings,
        ]);

        $user->assignRole([config('panel.userrole')]);

        return $user;
    }
}
