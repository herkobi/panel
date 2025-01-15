<?php

namespace App\Http\Requests\Admin\Settings\Settings;

use Illuminate\Foundation\Http\FormRequest;

class SystemSettingsUpdateRequest extends FormRequest
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
            'language' => ['required', 'string', 'exists:languages,code'],
            'location' => ['required', 'string', 'exists:countries,code'],
            'currency' => ['required', 'string', 'exists:currencies,iso_code'],
            'tax' => ['required', 'string', 'exists:taxes,code'],
            'timezone' => ['required', 'string', 'timezone'],
            'dateformat' => ['required', 'string'],
            'timeformat' => ['required', 'string'],
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
            'language.required' => 'Lütfen bir arayüz dili seçiniz.',
            'language.exists' => 'Seçilen dil geçerli değil.',

            'location.required' => 'Lütfen bir konum seçiniz.',
            'location.exists' => 'Seçilen konum geçerli değil.',

            'currency.required' => 'Lütfen bir para birimi seçiniz.',
            'currency.exists' => 'Seçilen para birimi geçerli değil.',

            'tax.required' => 'Lütfen bir vergi oranı seçiniz.',
            'tax.exists' => 'Seçilen vergi oranı geçerli değil.',

            'timezone.required' => 'Lütfen bir zaman dilimi seçiniz.',
            'timezone.timezone' => 'Geçerli bir zaman dilimi seçiniz.',

            'dateformat.required' => 'Lütfen bir tarih formatı seçiniz.',
            'timeformat.required' => 'Lütfen bir saat formatı seçiniz.',
        ];
    }
}
