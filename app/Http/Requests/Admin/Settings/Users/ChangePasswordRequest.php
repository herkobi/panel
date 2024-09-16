<?php

namespace App\Http\Requests\Admin\Settings\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
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
            'password.required' => 'Lütfen şifreyi giriniz',
            'password.password' => 'Lütfen geçerli formatta şifre giriniz',

            'password_confirmation.required' => 'Lütfen şifreyi tekrar giriniz',
            'password_confirmation.string' => 'Lütfen geçerli bir şifre giriniz',
            'password_confirmation.same' => 'Girmiş olduğunuz şifre aynı değil. Lütfen aynı şifreyi giriniz.',
        ];
    }

}
