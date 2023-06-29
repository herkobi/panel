<?php

namespace App\Http\Requests\PermissionGroups;

use App\Enums\UserType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class PermissionGroupCreateRequest extends FormRequest
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
            'name' => ['required', 'string', Rule::unique('permissiongroups', 'name')],
            'type' => ['required', new Enum(UserType::class)],
            'desc' => 'max:255',
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
            'name.required' => 'Lütfen başlık giriniz',
            'name.unique' => 'Bu isimde girilmiş grup adı bulunmaktadır',
            'type.required' => 'Lütfen kullanıcı türünü seçiniz',
            'type.integer' => 'Seçmiş olduğunuz kullanıcı türü değeri rakam olmalıdır'
        ];
    }
}
