<?php

namespace App\Http\Requests\Admin\Settings\Tax;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class TaxUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => ['required', 'integer', new Enum(Status::class)],
            'title' => ['required', 'string', 'max:255', Rule::unique('taxes', 'title')->ignore($this->tax, 'id')],
            'desc' => ['nullable', 'string'],
            'code' => ['required', 'string'],
            'value' => ['required', 'numeric'],
            'country_id' => ['exists:countries,id', 'required']
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

            /**
             * Status Messages
             */
            'status.required' => 'Lütfen durum giriniz',
            'status.integer' => 'Lütfen geçerli bir durum giriniz',

            /**
             * Title Messages
             */
            'title.required' => 'Lütfen vergi adını giriniz',
            'title.string' => 'Lütfen geçerli bir vergi adı giriniz',
            'title.max' => 'Lütfen vergi adını daha kısa giriniz',
            'title.unique' => 'Bu isimde kayıtlı vergi bulunmaktadır',

            /**
             * Desc Messages
             */
            'desc.string' => 'Lütfen geçerli bir açıklama giriniz',

            /**
             * Code Messages
             */
            'code.required' => 'Lütfen vergi adının kısa kodunu giriniz',
            'code.string' => 'Lütfen geçerli bir değer giriniz',

            /**
             * Value Messages
             */
            'value.required' => 'Lütfen vergi oranını giriniz',
            'value.numeric' => 'Lütfen geçerli bir vergi oranı giriniz',

            /**
             * Country ID Messages
             */
            'country_id.exists' => 'Lütfen geçerli bir ülke seçiniz',
            'country_id.required' => 'Lütfen ülke seçiniz',

        ];
    }
}
