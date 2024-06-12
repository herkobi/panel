<?php

namespace App\Http\Requests\Admin\Accounts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeEmailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->user, 'id')],
            'email_confirmation' => ['required', 'string', 'email', 'max:255', 'same:email']
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
            'email.string' => __('admin/accounts/request.email.string'),
            'email.required' => __('admin/accounts/request.email.required'),
            'email.email' => __('admin/accounts/request.email.email'),
            'email.max' => __('admin/accounts/request.email.max'),
            'email.unique' => __('admin/accounts/request.email.unique'),

            'email_confirmation.required' => __('admin/accounts/request.email_confirmation.required'),
            'email_confirmation.string' => __('admin/accounts/request.email_confirmation.string'),
            'email_confirmation.email' => __('admin/accounts/request.email_confirmation.email'),
            'email_confirmation.max' => __('admin/accounts/request.email_confirmation.max'),
            'email_confirmation.same' => __('admin/accounts/request.email_confirmation.same'),
        ];
    }

}
