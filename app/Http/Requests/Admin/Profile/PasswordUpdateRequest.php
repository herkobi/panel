<?php

namespace App\Http\Requests\Admin\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'old_password' => ['required'],
            'password' => ['required', 'string', Password::default()],
            'password_confirmation' => ['required', 'string', 'same:password']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'old_password.required' => 'Lütfen kullandığınız şifrenizi giriniz',

            'password.required' => 'Lütfen yeni şifrenizi giriniz',
            'password.string' => 'Lütfen geçerli bir şifre giriniz',

            'password_confirmation.required' => 'Lütfen şifreyi tekrar giriniz',
            'password_confirmation.string' => 'Lütfen geçerli bir şifre giriniz',
            'password_confirmation.same' => 'Girmiş olduğunuz şifre aynı değil. Lütfen aynı şifreyi giriniz.',
        ];
    }
}
