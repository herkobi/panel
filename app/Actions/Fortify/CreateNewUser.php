<?php

namespace App\Actions\Fortify;

use App\Enums\UserType;
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

        /**
         * Sözleşmenin kabul edildiğini belirtir. Lazım olabilir diye kayıt altına alınıyor.
         */
        $terms = 1;

        /**
         * Genel sistem ayarları, userrole ve adminrole değerleri çıkarılarak kullanıcıya aktarılması için
         * user_settings değişkenine atanıyor ve değer json formatına dönüştürülüyor.
         */
        $user_settings = Settings::whereNotIn('key', ['userrole', 'adminrole'])->pluck('value', 'key');
        $user_settings = json_encode($user_settings, JSON_UNESCAPED_SLASHES);

        /**
         * Kullanıcı kaydı gerçekleştiriliyor.
         * type değeri UserType Enum dosyasından USER olarak belirtiliyor.
         * settings değeri yukarıda tanımlanan user_settings değişkeni ile dolduruluyor.
         */
        $user = User::create([
            'type' => UserType::USER,
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'terms' => $terms,
            'settings' => $user_settings,
        ]);

        /**
         * Sistem ayarlarındaki kullanıcılara atanacak rol kayıt edilen kullanıcıya aktarılıyor.
         * Bu yapı AppServiceProviders içinde tanımlanmıştır.
         */
        $user->assignRole([config('panel.userrole')]);

        return $user;
    }
}
