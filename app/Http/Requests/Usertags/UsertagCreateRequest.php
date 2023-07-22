<?php

namespace App\Http\Requests\Usertags;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

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
            'status' => ['required', 'integer', new Enum(Status::class)],
            'name' => ['required', 'string', Rule::unique('usertags', 'name')],
            'color' => 'string',
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
            'name.required' => 'Lütfen etiket adını giriniz',
            'name.unique' => 'Bu isimde girilmiş etiket bulunmaktadır',
            'color.string' => 'Lütfen geçerli bir rek kodu giriniz',
        ];
    }
}
