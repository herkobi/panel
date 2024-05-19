<?php

namespace App\Http\Requests\Admin\Gateways\Bac;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class BacUpdateRequest extends FormRequest
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
            'status.required' => 'Lütfen durum seçiniz',
            'status.integer' => 'Lütfen geçerli bir durum seçiniz',

            /**
             * Title Messages
             */
            'title.required' => 'Lütfen ödeme sistemi adını giriniz',
            'title.string' => 'Lütfen geçerli bir ödeme sistemi adı giriniz',
            'title.max' => 'Lütfen daha kısa ödeme sistemi adı giriniz',

            /**
             * Currency Messages
             */
            'currency_id.exists' => 'Lütfen para birimi seçiniz',
            'currency_id.numeric' => 'Lütfen geçerli bir para birimi seçiniz',

            /**
             * Account Name Messages
             */
            'account_name.required' => 'Lütfen hesap adını giriniz',
            'account_name.string' => 'Lütfen geçerli bir hesap adı giriniz',
            'account_name.max' => 'Lütfen daha kısa hesap adı giriniz',

            /**
             * Account Bank Messages
             */
            'account_bank.required' => 'Lütfen banka adını giriniz',
            'account_bank.string' => 'Lütfen geçerli bir banka adı giriniz',
            'account_bank.max' => 'Lütfen daha kısa banka adı giriniz',

            /**
             * Account Branch Messages
             */
            'account_code.numeric' => 'Lütfen şube kodunu giriniz',
            'account_code.required_with' => 'Lütfen daha kısa şube kodu giriniz',

            /**
             * Account Number Messages
             */
            'account_number.numeric' => 'Lütfen hesap numarasını sadece rakam olarak giriniz',
            'account_number.required_with' => 'Lütfen hesap numarasını giriniz',

            /**
             * Account IBAN Messages
             */
            'account_iban.required_without_all' => 'Lütfen IBAN numarasını giriniz',
        ];
    }

}
