<?php

namespace App\Http\Requests\User\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'title' => ['string', 'max:255'],
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
            'name.required' => 'Lütfen isminizi giriniz.',
            'name.string' => 'Lütfen geçerli bir isim giriniz.',
            'name.max' => 'Lütfen isminizi daha kısa giriniz.',
            'surname.required' => 'Lütfen soyadınızı giriniz.',
            'surname.string' => 'Lütfen geçerli bir soyad giriniz.',
            'surname.max' => 'Lütfen soyadınızı daha kısa giriniz.',
            'title.string' => 'Lütfen geçerli bir görev giriniz.',
            'title.max' => 'Lütfen görevinizi daha kısa giriniz.',
        ];
    }
}
