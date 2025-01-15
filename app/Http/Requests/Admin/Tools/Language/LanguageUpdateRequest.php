<?php

namespace App\Http\Requests\Admin\Tools\Language;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Status;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class LanguageUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', new Enum(Status::class)],
            'name' => ['required', 'string', 'max:100', Rule::unique('languages', 'name')->ignore($this->language, 'id')],
            'code' => ['required', 'string', 'size:2', Rule::unique('languages', 'code')->ignore($this->language, 'id'), 'alpha', 'lowercase'],
            'regional_code' => ['required', 'string', 'size:5', Rule::unique('languages', 'regional_code')->ignore($this->language, 'id')],
            'charset' => ['required', 'string', 'max:20'],
            'direction' => ['required', 'string', 'in:ltr,rtl'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Durum alanı zorunludur.',
            'status.enum' => 'Durum geçersiz.',

            'name.required' => 'Dil adı alanı zorunludur.',
            'name.string' => 'Dil adı metin olmalıdır.',
            'name.max' => 'Dil adı en fazla :max karakter olabilir.',
            'name.unique' => 'Bu dil adı zaten kayıtlı.',

            'code.required' => 'Dil kodu alanı zorunludur.',
            'code.string' => 'Dil kodu metin olmalıdır.',
            'code.size' => 'Dil kodu :size karakter olmalıdır.',
            'code.unique' => 'Bu dil kodu zaten kayıtlı.',
            'code.alpha' => 'Dil kodu sadece harflerden oluşmalıdır.',
            'code.lowercase' => 'Dil kodu küçük harflerden oluşmalıdır.',

            'regional_code.required' => 'Bölgesel kod alanı zorunludur.',
            'regional_code.string' => 'Bölgesel kod metin olmalıdır.',
            'regional_code.size' => 'Bölgesel kod :size karakter olmalıdır.',
            'regional_code.unique' => 'Bu bölgesel kod zaten kayıtlı.',

            'charset.required' => 'Karakter seti alanı zorunludur.',
            'charset.string' => 'Karakter seti metin olmalıdır.',
            'charset.max' => 'Karakter seti en fazla :max karakter olabilir.',

            'direction.required' => 'Yazım yönü alanı zorunludur.',
            'direction.string' => 'Yazım yönü metin olmalıdır.',
            'direction.in' => 'Yazım yönü geçersiz.',
        ];
    }
}
