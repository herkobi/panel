<?php

namespace App\Http\Requests\Admin\Profile;

use Illuminate\Foundation\Http\FormRequest;

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
            'title' => ['string', 'max:255'],
            'about' => ['string'],
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
             * Title Messages
             */
            'title.string' => 'Lütfen geçerli bir görev giriniz',
            'title.max' => 'Lütfen daha kısa görev giriniz',

            /**
             * About Messages
             */
            'about.string' => 'Lütfen geçerli bir içerik giriniz',
        ];
    }
}
