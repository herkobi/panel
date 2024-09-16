<?php

namespace App\Http\Requests\Admin\Accounts;

use App\Enums\AccountStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class StatusUpdateRequest extends FormRequest
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
            'status' => ['required', 'integer', new Enum(AccountStatus::class)],
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
            'status.required' => 'Lütfen durum seçiniz',
            'status.integer' => 'Lütfen geçerli bir durum seçiniz',

        ];
    }
}
