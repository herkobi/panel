<?php

namespace App\Http\Requests\Admin\Tools\Country;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Status;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class CountryUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', new Enum(Status::class)],
            'name' => ['required', 'string', 'max:100',  Rule::unique('countries', 'name')->ignore($this->country, 'id')],
            'code' => ['required', 'string', 'size:2', Rule::unique('countries', 'code')->ignore($this->country, 'id'), 'alpha', 'uppercase'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Durum alanı zorunludur.',
            'status.integer' => 'Durum alanı sayısal olmalıdır.',
            'status.in' => 'Durum geçersiz.',

            'name.required' => 'Ülke adı alanı zorunludur.',
            'name.string' => 'Ülke adı metin olmalıdır.',
            'name.max' => 'Ülke adı en fazla :max karakter olabilir.',
            'name.unique' => 'Bu ülke adı zaten kayıtlı.',

            'code.required' => 'Ülke kodu alanı zorunludur.',
            'code.string' => 'Ülke kodu metin olmalıdır.',
            'code.size' => 'Ülke kodu :size karakter olmalıdır.',
            'code.unique' => 'Bu ülke kodu zaten kayıtlı.',
            'code.alpha' => 'Ülke kodu sadece harflerden oluşmalıdır.',
            'code.uppercase' => 'Ülke kodu büyük harflerden oluşmalıdır.',
        ];
    }
}
