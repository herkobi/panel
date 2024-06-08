<?php

namespace App\Http\Requests\Admin\Accounts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VerifyEmailRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255'],
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
        ];
    }

}
