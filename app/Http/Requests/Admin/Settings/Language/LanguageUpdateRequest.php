<?php

namespace App\Http\Requests\Admin\Settings\Language;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class LanguageUpdateRequest extends FormRequest
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
            'status' => ['required', new Enum(Status::class)],
            'title' => ['required', 'string', 'max:255', Rule::unique('languages', 'title')->ignore($this->language, 'id')],
            'desc' => ['nullable', 'string', 'max:255'],
            'code' => ['required'],
            'direction' => ['required', 'in:ltr,rtl'],
            'charset' => ['required', 'string', 'max:32'],
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
            'title.required' => 'Lütfen dilin adını giriniz',
            'title.string' => 'Lütfen geçerli bir dil adı giriniz',
            'title.max' => 'Lütfen dilin adını daha kısa giriniz',
            'title.unique' => 'Bu isimde kayıtlı dil bulunmaktadır',

            /**
             * Desc Messages
             */
            'desc.string' => 'Lütfen geçerli bir dil açıklaması giriniz',
            'desc.max' => 'Lütfen daha kısa bir açıklama giriniz',

            /**
             * Code Messages
             */
            'code.required' => 'Lütfen geçerli bir dil kodu giriniz',

            /**
             * Direction Messages
             */
            'direction.required' => 'Lütfen dilin yazım şeklini seçiniz',
            'direction.in' => 'Lütfen geçerli bir yazım şekli seçiniz',

            /**
             * Charset Messages
             */
            'charset.required' => 'Lütfen dile ait karakter kodlamasını',
            'charset.string' => 'Lütfen geçerli bir karakter seti giriniz',
            'charset.max' => 'Lütfen karakter setini daha kısa giriniz',
        ];
    }

}
