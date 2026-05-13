<?php

declare(strict_types=1);

namespace App\Actions\Fortify;

use App\Concerns\App\Profile\ProfileValidationRules;
use App\Concerns\Common\PasswordValidationRules;
use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, ProfileValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            ...$this->profileRules(),
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $input['password'],
            'status' => UserStatus::Draft,
            'user_type' => UserType::Member,
        ]);
    }
}
