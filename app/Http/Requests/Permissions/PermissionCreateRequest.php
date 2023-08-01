<?php

namespace App\Http\Requests\Permissions;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class PermissionCreateRequest extends FormRequest
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
            'group_id' => ['required', 'not_in:0', 'integer'],
            'name' => ['required', Rule::unique('permissions', 'name')],
            'text' => 'required',
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
            'group_id.required' => 'Lütfen izin grubu seçiniz',
            'group_id.not_in' => 'Lütfen izin grubu seçiniz',
            'group_id.integer' => 'İzin grubu rakam olmalıdır',
            'name.required' => 'Lütfen izin kodunu giriniz',
            'name.unique' => 'Bu isimde girilmiş izin kodu bulunmaktadır',
            'text.required' => 'Lütfen izin açıklamasını giriniz',
        ];
    }
}
