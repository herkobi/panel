<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UserCreateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ]
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
            'name.required' => 'Lütfen kullanıcının ad ve soyadını giriniz',
            'name.max:255' => 'Lütfen en fazla 255 karakter giriniz',
            'email.required' => 'Lütfen kullanıcının e-posta adresini giriniz',
            'email.email' => 'Lütfen geçerli formatta e-posta adresi giriniz',
            'email.max:255' => 'Lütfen en fazla 255 karakter giriniz',
        ];
    }

}
