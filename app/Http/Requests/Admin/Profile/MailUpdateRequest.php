<?php

namespace App\Http\Requests\Admin\Profile;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MailUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'email_confirmation' => ['required', 'string', 'email', 'max:255', 'same:email'],
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
            'email.required' => 'Lütfen e-posta adresini giriniz.',
            'email.string' => 'Lütfen geçerli bir e-posta adresi giriniz.',
            'email.email' => 'Lütfen doğru formatta e-posta adresi giriniz.',
            'email.max' => 'Lütfen e-posta adresini daha kısa giriniz.',
            'email.unique' => 'Girmiş olduğunuz e-posta adresi kullanımdadır. Lütfen daha farklı e-posta adresi giriniz.',

            'email_confirmation.required' => 'Lütfen onay e-posta adresini giriniz.',
            'email_confirmation.string' => 'Lütfen geçerli bir onay e-posta adresi giriniz.',
            'email_confirmation.email' => 'Lütfen doğru formatta onay e-posta adresi giriniz.',
            'email_confirmation.max' => 'Lütfen onay e-posta adresini daha kısa giriniz.',
            'email_confirmation.same' => 'Girmiş olduğunuz e-posta adresleri uyuşmuyor. Lütfen kontrol edip e-posta adresi tekrar giriniz.',
        ];
    }
}
