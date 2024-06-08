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
            'status.required' => __('admin/accounts/request.status.required'),
            'status.integer' => __('admin/accounts/request.status.integer'),

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

        ];
    }
}
