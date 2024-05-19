<?php

namespace App\Http\Requests\Admin\Page;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class PageUpdateRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255', Rule::unique('pages', 'title')->ignore($this->page, 'id')],
            'text' => ['max:255']
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
            'title.required' => 'Lütfen sayfa adını giriniz',
            'title.string' => 'Lütfen geçerli bir sayfa adı giriniz',
            'title.max' => 'Lütfen sayfa adını daha kısa giriniz',
            'title.unique' => 'Bu isimde kayıtlı sayfa bulunmaktadır',

            /**
             * Desc Messages
             */
            'text.required' => 'Lütfen içerik giriniz',

        ];
    }

}
