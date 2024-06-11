<?php

namespace App\Http\Requests\Admin\Gateways\Bac;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class BacCreateRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'desc' => ['nullable'],
            'currency_id' => ['exists:currencies,id', 'numeric'],
            'account_name' => ['required', 'string', 'max:255'],
            'account_bank' => ['required', 'string', 'max:255'],
            'account_code' => ['nullable', 'numeric', 'required_with:account_number'],
            'account_number' => ['nullable', 'numeric', 'required_with:account_code'],
            'account_iban' => ['nullable', 'required_without_all:account_code,account_number'],
            'account_swift' => ['nullable'],
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
            'status.required' => __('admin/gateways/bac/request.status.required'),
            'status.integer' => __('admin/gateways/bac/request.status.integer'),

            /**
             * Title Messages
             */
            'title.required' => __('admin/gateways/bac/request.title.required'),
            'title.string' => __('admin/gateways/bac/request.title.string'),
            'title.max' => __('admin/gateways/bac/request.title.max'),

            /**
             * Currency Messages
             */
            'currency_id.exists' => __('admin/gateways/bac/request.currency_id.exists'),
            'currency_id.numeric' => __('admin/gateways/bac/request.currency_id.numeric'),

            /**
             * Account Name Messages
             */
            'account_name.required' => __('admin/gateways/bac/request.account_name.required'),
            'account_name.string' => __('admin/gateways/bac/request.account_name.string'),
            'account_name.max' => __('admin/gateways/bac/request.account_name.max'),

            /**
             * Account Bank Messages
             */
            'account_bank.required' => __('admin/gateways/bac/request.account_bank.required'),
            'account_bank.string' => __('admin/gateways/bac/request.account_bank.string'),
            'account_bank.max' => __('admin/gateways/bac/request.account_bank.max'),

            /**
             * Account Branch Messages
             */
            'account_code.numeric' => __('admin/gateways/bac/request.account_code.numeric'),
            'account_code.required_with' => __('admin/gateways/bac/request.account_code.required_with'),

            /**
             * Account Number Messages
             */
            'account_number.numeric' => __('admin/gateways/bac/request.account_number.numeric'),
            'account_number.required_with' => __('admin/gateways/bac/request.account_number.required_with'),

            /**
             * Account IBAN Messages
             */
            'account_iban.required_without_all' => __('admin/gateways/bac/request.account_iban.required_without_all'),
        ];
    }
}
