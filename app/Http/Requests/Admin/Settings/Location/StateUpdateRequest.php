<?php

namespace App\Http\Requests\Admin\Settings\Location;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class StateUpdateRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255', Rule::unique('states', 'title')->ignore($this->route('id'), 'id')],
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
            'title.required' => 'Lütfen eyalet/şehir adını giriniz',
            'title.string' => 'Lütfen geçerli bir eyalet/şehir adı giriniz',
            'title.max' => 'Lütfen eyalet/şehir adını daha kısa giriniz',
            'title.unique' => 'Bu isimde kayıtlı eyalet/şehir bulunmaktadır',

            /**
             * Country ID Messages
             */
            'country_id.exists' => 'Lütfen geçerli bir ülke seçiniz',
            'country_id.required' => 'Lütfen ülke seçiniz',

        ];
    }

}
