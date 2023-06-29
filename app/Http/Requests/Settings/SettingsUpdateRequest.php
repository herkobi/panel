<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SettingsUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'language' => ['required', 'string'],
            'timezone' => ['required', 'string'],
            'datetime' => ['required', 'string']
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
            'language.required' => 'Lütfen dil giriniz',
            'language.string' => 'Dil değeri metin olmalıdır',
            'timezone.required' => 'Lütfen zaman dilimi giriniz',
            'timezone.string' => 'Zaman dilimi değeri metin olmalıdır',
            'datetime.required' => 'Lütfen tarih/saat formatı giriniz',
            'datetime.string' => 'Tarih/saat formatı metin olmalıdır',
        ];
    }
}
