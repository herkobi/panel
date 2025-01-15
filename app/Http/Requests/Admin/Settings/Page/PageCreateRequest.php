<?php

namespace App\Http\Requests\Admin\Settings\Page;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\Status;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class PageCreateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => ['required', new Enum(Status::class)],
            'title' => ['required', 'string', 'max:100', Rule::unique('pages', 'title')],
            'content' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Durum alanı zorunludur.',
            'status.enum' => 'Durum geçersiz.',

            'title.required' => 'Sayfa adı alanı zorunludur.',
            'title.string' => 'Sayfa adı metin olmalıdır.',
            'title.max' => 'Sayfa adı en fazla :max karakter olabilir.',
            'title.unique' => 'Bu sayfa adı zaten kayıtlı.',

            'content.required' => 'Sayfa kodu alanı zorunludur.',
            'content.string' => 'Sayfa içeriği metin olmalıdır.',
        ];
    }
}
