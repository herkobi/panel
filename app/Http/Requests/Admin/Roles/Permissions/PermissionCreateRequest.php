<?php

namespace App\Http\Requests\Admin\Roles\Permissions;

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
            'parent_id' => ['integer', 'required'],
            'name' => ['required', Rule::unique('permissions', 'name')],
            'desc' => 'required',
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
            'parent_id.required' => 'Lütfen izin türünü giriniz',
            'parent_id.integer' => 'Lütfen geçerli bir izin türü giriniz',
            'name.required' => 'Lütfen izin kodunu giriniz',
            'name.unique' => 'Bu isimde girilmiş izin kodu bulunmaktadır',
            'desc.required' => 'Lütfen izin açıklamasını giriniz',
        ];
    }
}
