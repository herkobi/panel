<?php

namespace App\Http\Requests\Admin\Accounts;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class AccountUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user->id, 'id')],
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
             * Name Messages
             */
            'name.required' => 'Lütfen isim giriniz',
            'name.string' => 'Lütfen geçerli bir isim giriniz',
            'name.max' => 'Lütfen ismi daha kısa giriniz',

            /**
             * Desc Messages
             */
            'surname.required' => 'Lütfen soyisim giriniz',
            'surname.string' => 'Lütfen geçerli bir soyisim giriniz',
            'surname.max' => 'Lütfen soyismi daha kısa giriniz',

            /**
             * E-mail Messages
             */
            'email.string' => 'Lütfen geçerli bir e-posta adresi giriniz',
            'email.required' => 'Lütfen e-posta adresi giriniz',
            'email.email' => 'Lütfen geçerli bir e-posta adresi giriniz',
            'email.max' => 'Lütfen daha kısa bir e-posta adresi giriniz',

        ];
    }
}
