<?php

namespace App\Http\Requests\Admin\Roles\Permissions;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

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
            'type' => ['required', 'integer', new Enum(UserType::class)],
            'parent_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')],
            'desc' => ['required', 'string', 'max:255'],
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
            'desc.max' => 'Lütfen daha kısa açıklama giriniz'
        ];
    }
}
