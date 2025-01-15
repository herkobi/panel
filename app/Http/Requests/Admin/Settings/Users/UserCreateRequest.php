<?php

namespace App\Http\Requests\Admin\Settings\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', Password::default()],
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

            'name.required' => 'Lütfen isim giriniz',
            'name.string' => 'Lütfen geçerli bir isim giriniz',
            'name.max' => 'Lütfen ismi daha kısa giriniz',

            'surname.required' => 'Lütfen soyisim giriniz',
            'surname.string' => 'Lütfen geçerli bir soyisim giriniz',
            'surname.max' => 'Lütfen soyismi daha kısa giriniz',

            'title.string' => 'Lütfen geçerli bir isim giriniz',
            'title.max' => 'Lütfen ismi daha kısa giriniz',

            'email.string' => 'Lütfen geçerli bir e-posta adresi giriniz',
            'email.required' => 'Lütfen e-posta adresi giriniz',
            'email.email' => 'Lütfen geçerli bir e-posta adresi giriniz',
            'email.max' => 'Lütfen daha kısa bir e-posta adresi giriniz',

            'password.required' => 'Lütfen şifre giriniz',
            'password.password' => 'Lütfen uygun formatta şifre giriniz',
        ];
    }
}
