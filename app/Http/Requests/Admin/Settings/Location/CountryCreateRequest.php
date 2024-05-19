<?php

namespace App\Http\Requests\Admin\Settings\Location;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class CountryCreateRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255', Rule::unique('countries', 'title')],
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
            'title.required' => 'Lütfen ülke adını giriniz',
            'title.string' => 'Lütfen geçerli bir ülke adı giriniz',
            'title.max' => 'Lütfen ülke adını daha kısa giriniz',
            'title.unique' => 'Bu isimde kayıtlı ülke bulunmaktadır',

            /**
             * Code Messages
             */
            'code.required' => 'Lütfen ülke kısa kodunu giriniz',

        ];
    }
}
