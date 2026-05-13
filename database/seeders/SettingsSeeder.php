<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Tax;
use App\Services\Panel\Settings\General\SettingsService;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $country = Country::query()->where('code', 'TR')->first();
        $currency = Currency::query()->where('code', 'TRY')->first();
        $language = Language::query()->where('code', 'tr')->first();
        $tax = Tax::query()->where('name', 'KDV %20')->first();

        $settings = [
            'app_name' => 'Herkobi Panel',
            'app_slogan' => null,
            'default_country_id' => $country?->id,
            'default_currency_id' => $currency?->id,
            'default_tax_id' => $tax?->id,
            'default_language_code' => $language?->code ?? 'tr',
            'default_timezone' => 'Europe/Istanbul',
        ];

        foreach ($settings as $key => $value) {
            Setting::query()->updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'group' => SettingsService::KEYS[$key],
                ],
            );
        }
    }
}
