<?php

namespace App\Http\Requests\Usertags;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsertagUpdateRequest extends FormRequest
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
            'status' => ['required', 'integer', 'between:0,1'],
            'name' => ['required', 'string', Rule::unique('usertags', 'name')->ignore($this->usertag->id, 'id')],
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
            'status.required' => 'Lütfen durum seçiniz',
            'status.integer' => 'Durum değeri rakam olmalıdır',
            'status.between' => 'Durum değeri 0 ya da 1 olabilir',
            'name.required' => 'Lütfen etiket adını giriniz',
            'name.unique' => 'Bu isimde girilmiş etiket bulunmaktadır',
            'color.string' => 'Lütfen geçerli bir rek kodu giriniz',
            'desc.string' => 'Lütfen geçerli bir açıklama giriniz'
        ];
    }
}
