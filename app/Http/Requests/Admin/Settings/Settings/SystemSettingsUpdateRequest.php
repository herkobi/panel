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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'userrole' => ['required'],
            'adminrole' => ['required'],
            'language' => ['required'],
            'location' => ['required'],
            'currency' => ['required'],
            'tax' => ['required'],
            'timezone' => ['required'],
            'dateformat' => ['required'],
            'timeformat' => ['required'],
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
             * Messages
             */
            'userrole.required' => 'Lütfen hesaplar için genel rol tanımlayınız',
            'adminrole.required' => 'Lütfen kullanıcılar için genel rol tanımlayınız',
            'language.required' => 'Lütfen sistemde kullanılacak genel dili seçiniz',
            'timezone.required' => 'Lütfen sistemde kullanılacak genel zaman aralığını seçiniz',
            'dateformat.required' => 'Lütfen sistemde kullanılacak genel tarih formatını seçiniz',
            'timeformat.required' => 'Lütfen sistemde kullanılacak genel saat formatını seçiniz',
        ];
    }
}
