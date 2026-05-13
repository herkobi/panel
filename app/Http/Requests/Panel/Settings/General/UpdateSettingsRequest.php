<?php

declare(strict_types=1);

namespace App\Http\Requests\Panel\Settings\General;

use App\Enums\Status;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Tax;
use DateTimeZone;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSettingsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'app_name' => ['nullable', 'string', 'max:255'],
            'app_slogan' => ['nullable', 'string', 'max:255'],
            'logo_path' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'logo_dark_path' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'favicon_path' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
            'default_country_id' => [
                'nullable',
                'string',
                Rule::exists(Country::class, 'id')->where('status', Status::Active->value),
            ],
            'default_currency_id' => [
                'nullable',
                'string',
                Rule::exists(Currency::class, 'id')->where('status', Status::Active->value),
            ],
            'default_tax_id' => [
                'nullable',
                'string',
                Rule::exists(Tax::class, 'id')->where('status', Status::Active->value),
            ],
            'default_language_code' => [
                'nullable',
                'string',
                Rule::exists(Language::class, 'code')->where('status', Status::Active->value),
            ],
            'default_timezone' => ['nullable', 'string', Rule::in(DateTimeZone::listIdentifiers())],
        ];
    }
}
