<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Sistem ayarları.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $settings_data = ['userrole' => '3', 'adminrole' => '2', 'language' => 'tr', 'location' => 'TR', 'currency' => 'TRY', 'tax' => 'KDV', 'timezone' => 'Europe/Istanbul', 'dateformat' => 'd/m/Y', 'timeformat' => 'H:i'];
        $settings_data = json_encode($settings_data);
        $settings_key = 'settings';

        return [
            'key' => $settings_key,
            'value' => $settings_data
        ];
    }

    /**
     * Uygulama ayarları.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function appSettings()
    {
        return $this->state(function (array $attributes) {
            $app_data = ['title' => 'Herkobi', 'slogan' => 'Herkobi Panel', 'logo' => 'herkobi.png', 'favicon' => 'herkobi-favicon.png', 'email' => 'site@site.com'];
            $app_data = json_encode($app_data);
            $app_key = 'app';

            return [
                'key' => $app_key,
                'value' => $app_data
            ];
        });
    }
}
