<?php

namespace App\Actions\Fortify;

use App\Enums\UserType;
use App\Enums\AccountStatus;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
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

        /**
         * Genel sistem ayarları, userrole ve adminrole değerleri çıkarılarak kullanıcıya aktarılması için
         * user_settings değişkenine atanıyor ve değer json formatına dönüştürülüyor.
         */
        $user_settings = json_encode([
            'language' => config('panel.language'),
            'timezone' => config('panel.timezone'),
            'dateformat' => config('panel.dateformat'),
            'timeformat' => config('panel.timeformat'),
        ], JSON_UNESCAPED_SLASHES);

        $input['terms'] = $input['terms'] ? '1' : '0';

        $user = User::create([
            'status' => AccountStatus::ACTIVE,
            'type' => UserType::USER,
            'name' => $input['name'],
            'surname' => $input['surname'],
            'email' => $input['email'],
            'email_verified_at' => Carbon::now()->toDateTimeString(),
            'password' => Hash::make($input['password']),
            'terms' => $input['terms'],
            'settings' => $user_settings,
            'created_by' => 0,
            'created_by_name' => 'Owner'
        ]);

        /**
         * Sistem ayarlarındaki kullanıcılara atanacak rol kayıt edilen kullanıcıya aktarılıyor.
         */
        $role = Role::find(config('panel.userrole'));
        $user->assignRole($role->id);

        return $user;
    }
}
