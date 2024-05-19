<?php

namespace App\Http\Requests\Admin\Profile;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['string', 'max:255'],
            'email' => ['string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
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

            /**
             * Name Messages
             */
            'name.required' => 'Lütfen isim giriniz',
            'name.string' => 'Lütfen geçerli bir isim giriniz',
            'name.max' => 'Lütfen ismi daha kısa giriniz',

            /**
             * Desc Messages
             */
            'surname.required' => 'Lütfen soyisim giriniz',
            'surname.string' => 'Lütfen geçerli bir soyisim giriniz',
            'surname.max' => 'Lütfen soyismi daha kısa giriniz',

            /**
             * E-mail Messages
             */
            'email.string' => 'Lütfen geçerli bir e-posta adresi giriniz',
            'email.lowercase' => 'Lütfen e-posta adresini küçük harflerler giriniz',
            'email.email' => 'Lütfen geçerli bir e-posta adresi giriniz',
            'email.max' => 'Lütfen daha kısa bir e-posta adresi giriniz',

        ];
    }
}
