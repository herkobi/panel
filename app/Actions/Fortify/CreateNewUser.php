<?php

namespace App\Actions\Fortify;

use App\Enums\AccountStatus;
use App\Enums\UserType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Illuminate\Support\Str;

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
            'surname' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => $this->passwordRules(),
            'terms' => ['required']
        ])->validate();

        $input['terms'] = $input['terms'] ? '1' : '0';

        $user = User::create([
            'status' => AccountStatus::ACTIVE,
            'type' => UserType::USER,
            'name' => $input['name'],
            'surname' => $input['surname'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'terms' => $input['terms'],
            'created_by' => 0,
            'created_by_name' => 'Owner'
        ]);

        /**
         * Kullanıcı klasörü oluşturuluyor.
         */
        $folderName = 'user_' . Str::random(12);

        if (!Storage::disk('public')->exists($folderName)) {
            Storage::disk('public')->makeDirectory($folderName);
        }

        // User tablosuna user_folder bilgisini ekle
        $user->meta()->create([
            'title' => null,
            'url' => null,
            'phone' => null,
            'user_folder' => $folderName
        ]);

        return $user;
    }
}
