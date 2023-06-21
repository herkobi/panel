<?php

namespace App\Http\Requests\Usertags;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsertagCreateRequest extends FormRequest
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
            'name' => ['required', 'string', Rule::unique('usertags', 'name')],
            'color' => 'string',
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
            'name.required' => 'Lütfen etiket adını giriniz',
            'name.unique' => 'Bu isimde girilmiş etiket bulunmaktadır',
            'color.string' => 'Lütfen geçerli bir rek kodu giriniz',
            'desc.string' => 'Lütfen geçerli bir açıklama giriniz'
        ];
    }
}
