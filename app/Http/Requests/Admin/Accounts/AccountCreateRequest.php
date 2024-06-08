<?php

namespace App\Http\Requests\Admin\Accounts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class AccountCreateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'string', Password::default()],
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
             * Name Messages
             */
            'name.required' => __('admin/accounts/request.name.required'),
            'name.string' => __('admin/accounts/request.name.string'),
            'name.max' => __('admin/accounts/request.name.max'),

            /**
             * Desc Messages
             */
            'surname.required' => __('admin/accounts/request.surname.required'),
            'surname.string' => __('admin/accounts/request.surname.string'),
            'surname.max' => __('admin/accounts/request.surname.max'),

            /**
             * E-mail Messages
             */
            'email.string' => __('admin/accounts/request.email.string'),
            'email.required' => __('admin/accounts/request.email.required'),
            'email.email' => __('admin/accounts/request.email.email'),
            'email.max' => __('admin/accounts/request.email.max'),

            /**
             * Password Messages
             */
            'password.required' => __('admin/accounts/request.password.required'),
            'password.password' => __('admin/accounts/request.password.password'),
        ];
    }
}
