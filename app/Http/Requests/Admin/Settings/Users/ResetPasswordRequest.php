<?php

namespace App\Http\Requests\Admin\Settings\Users;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
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
            'email' => ['required', 'email', 'string']
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
            'email.required' => 'Lütfen e-posta adresini giriniz',
            'email.string' => 'Lütfen geçerli bir e-posta adresi giriniz',
            'email.email' => 'Lütfen geçerli bir e-posta adresi giriniz',
        ];
    }

}
