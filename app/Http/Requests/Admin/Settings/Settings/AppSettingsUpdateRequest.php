<?php

namespace App\Http\Requests\Admin\Settings\Settings;

use Illuminate\Foundation\Http\FormRequest;

class AppSettingsUpdateRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'slogan' => ['string', 'max:255'],
            'logo' => ['nullable','image', 'max:1024', 'mimes:jpg,jpeg,png,svg'],
            'favicon' => ['nullable','image', 'max:512', 'mimes:png,ico'],
            'email' => ['required', 'email', 'string', 'max:255'],
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
             * Title Messages
             */
            'title.required' => 'Lütfen uygulama adını giriniz',
            'title.string' => 'Lütfen geçerli bir uygulama adı giriniz',
            'title.max' => 'Lütfen uygulama adını daha kısa giriniz',

            /**
             * Slogan Messages
             */
            'slogan.string' => 'Lütfen uygulama sloganını giriniz',
            'slogan.max' => 'Lütfen daha kısa uygulama sloganı giriniz',

            /**
             * Logo Messages
             */
            'logo.image' => 'Lütfen geçerli bir resim yükleyiniz',
            'logo.max' => 'Lütfen daha düşük boyutta bir resim yükleyiniz',
            'logo.mimes' => 'Lütfen jpg, jpeg  ya da png formatında bir resim yükleyiniz',

            /**
             * Favicon Messages
             */
            'favicon.image' => 'Lütfen geçerli bir resim yükleyiniz',
            'favicon.max' => 'Lütfen daha düşük boyutta bir resim yükleyiniz',
            'favicon.mimes' => 'Lütfen ico ve png formatında bir resim yükleyiniz',

            /**
             * Email Messages
             */
            'email.required' => 'Lütfen e-posta adresini giriniz',
            'email.email' => 'Lütfen geçerli bir e-posta adresini giriniz',
            'email.string' => 'Lütfen geçerli bir e-posta adresi giriniz',
            'email.max' => 'Lütfen e-posta adresini daha kısa giriniz',
        ];
    }
}
