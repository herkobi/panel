<?php

namespace App\Http\Requests\Admin\Gateways\Paytr;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class PaytrUpdateRequest extends FormRequest
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
            'logo' => ['nullable','image', 'max:1024', 'mimes:jpg,jpeg,png'],
            'merchant_id' => ['required',],
            'merchant_key' => ['required'],
            'merchant_salt' => ['required'],
            'merchant_ok_url' => ['required', 'url'],
            'merchant_fail_url' => ['required', 'url'],
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
            'title.required' => 'Lütfen başlık giriniz',
            'title.string' => 'Lütfen geçerli bir başlık giriniz',
            'title.max' => 'Lütfen daha kısa başlık giriniz',

            /**
             * Currency Messages
             */
            'currency_id.exists' => 'Lütfen geçerli para birimi giriniz',
            'currency_id.numeric' => 'Lütfen para birimi giriniz',

            /**
             * Logo Messages
             */
            'logo.image' => 'Lütfen resim yükleyiniz',
            'logo.max' => 'Lütfen logonuzun boyutunu düşürünüz',
            'logo.mimes' => 'Lütfen jpg,jpeg veya png formatında resim yükleyiniz',

            /**
             * Account ID Messages
             */
            'merchant_id.required' => 'Lütfen mağaza kodunu giriniz',

            /**
             * Account Key Messages
             */
            'merchant_key.required' => 'Lütfen mağaza anahtarını giriniz',

            /**
             * Security Code Messages
             */
            'merchant_salt.required' => 'Lütfen güvenlik kodunu giriniz',

            /**
             * Success Return URL Messages
             */
            'merchant_ok_url.required' => 'Lütfen başarılı dönüş url\'sini giriniz',

            /**
             * Error Return URL Messages
             */
            'merchant_fail_url.required' => 'Lütfen hata dönüş url\'sini giriniz',

        ];
    }
}
