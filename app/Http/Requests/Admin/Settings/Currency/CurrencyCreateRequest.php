<?php

namespace App\Http\Requests\Admin\Settings\Currency;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class CurrencyCreateRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255', Rule::unique('currencies', 'title')],
            'symbol' => ['required'],
            'symbol_location' => ['required'],
            'thousand_sep' => ['required'],
            'decimal_sep' => ['required'],
            'decimal_number' => ['required', 'integer'],
            'code' => ['required']
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
            'title.required' => 'Lütfen para biriminin adını giriniz',
            'title.string' => 'Lütfen geçerli bir para birimi adı giriniz',
            'title.max' => 'Lütfen para birimini adını daha kısa giriniz',
            'title.unique' => 'Bu isimde kayıtlı para birimi bulunmaktadır',

            /**
             * Bilgiler Messages
             */
            'symbol.required' => 'Lütfen para birimine ait sembol giriniz',
            'symbol_location.required' => 'Lütfen para birimine ait sembolun konumunu giriniz',
            'thousand_sep.required' => 'Lütfen para birimine ait binlik ayırıcı giriniz',
            'decimal_sep.required' => 'Lütfen para birimine ait ondalık ayırıcı giriniz',
            'decimal_number.required' => 'Lütfen para birimine ait ondalık sayısı giriniz',
            'decimal_number.integer' => 'Lütfen ondalık değer olarak rakam giriniz',
            'code.required' => 'Lütfen para biriminin kodunu giriniz',
        ];
    }
}
