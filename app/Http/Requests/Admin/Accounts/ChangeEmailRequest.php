<?php

namespace App\Http\Requests\Admin\Accounts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeEmailRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user, 'id')],
            'email_confirmation' => ['required', 'string', 'email', 'max:255', 'same:email']
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
            'email.max' => 'Lütfen daha kısa bir e-posta adresi giriniz',
            'email.unique' => 'Girmiş olduğunuz e-posta adresi ile kayıtlı bir kullanıcı bulunmaktadır.',

            'email_confirmation.required' => 'Lütfen e-posta adresini giriniz',
            'email_confirmation.string' => 'Lütfen geçerli bir e-posta adresi giriniz',
            'email_confirmation.email' => 'Lütfen geçerli bir e-posta adresi giriniz',
            'email_confirmation.max' => 'Lütfen daha kısa bir e-posta adresi giriniz',
            'email_confirmation.same' => 'Girmiş olduğunuz e-posta adresi aynı değil. Lütfen aynı e-posta adresini giriniz.',
        ];
    }
}
