<?php

namespace App\Http\Requests\Roles;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class RoleCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
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
            'name' => ['required', Rule::unique('roles', 'name')],
            'type' => ['required', new Enum(UserType::class) ],
            'desc' => 'string',
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
            'name.required' => 'Lütfen yetki adını giriniz',
            'name.unique' => 'Bu isimde kayıtlı yetki bulunmaktadır',
            'type.required' => 'Lütfen tür seçiniz',
            'desc.string' => 'Lütfen açıklama alanını metin giriniz'
        ];
    }

}
