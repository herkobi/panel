<?php

namespace App\Http\Requests\User\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class PasswordUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'old_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', Password::default(), 'confirmed', 'different:old_password'],
            'password_confirmation' => ['required', 'string'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'old_password.required' => 'Lütfen kullandığınız şifrenizi giriniz',
            'old_password.string' => 'Lütfen kullandığınız şifrenizi giriniz',
            'old_password.current_password' => 'Lütfen kullandığınız şifrenizi doğru giriniz',

            'password.required' => 'Lütfen yeni şifrenizi giriniz',
            'password.string' => 'Lütfen geçerli bir şifre giriniz',
            'password.password' => 'Lütfen geçerli bir şifre giriniz',
            'password.confirmed' => 'Lütfen şifrenizi onaylayınız',
            'password.different' => 'Lütfen eski şifrenizden farklı bir şifre giriniz',

            'password_confirmation.required' => 'Lütfen yeni şifrenizi tekrar giriniz',
            'password_confirmation.string' => 'Lütfen yeni şifrenizi tekrar giriniz',
        ];
    }
}
