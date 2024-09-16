<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'title',
                'value' => 'Herkobi Panel'
            ],
            [
                'key' => 'slogan',
                'value' => 'Herkobi SaaS Panel'
            ],
            [
                'key' => 'logo',
                'value' => 'herkobi-favicon.png'
            ],
            [
                'key' => 'favicon',
                'value' => 'herkobi-favicon.png'
            ],
            [
                'key' => 'email',
                'value' => 'contact@example.com'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
