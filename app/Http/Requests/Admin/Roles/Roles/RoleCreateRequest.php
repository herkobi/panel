<?php

namespace App\Http\Requests\Admin\Roles\Roles;

use App\Enums\Status;
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
            'status' => ['required', 'integer', new Enum(Status::class)],
            'name' => ['required','string', 'max:255', Rule::unique('roles', 'name')],
            'type' => ['required', 'integer', new Enum(UserType::class) ],
            'desc' => ['nullable', 'string', 'max:255']
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
            'status.required' => 'Lütfen durum seçiniz',
            'status.integer' => 'Lütfen geçerli bir durum seçiniz',

            'name.required' => 'Lütfen yetki adını giriniz',
            'name.string' => 'Lütfen geçerli bir isim giriniz',
            'name.max' => 'Lütfen daha kısa bir yetki adı giriniz',
            'name.unique' => 'Bu isimde kayıtlı yetki bulunmaktadır',

            'type.required' => 'Lütfen kullanıcı türü seçiniz',
            'type.integer' => 'Lütfen geçerli bir kullanıcı tür seçiniz',

            'desc.string' => 'Lütfen açıklama alanını metin giriniz',
            'desc.max' => 'Lütfen daha kısa bir açıklama giriniz',
        ];
    }

}
