<?php

namespace Database\Seeders;

use App\Models\Settings;
use Illuminate\Database\Seeder;

class CreateSystemSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_values = [
            'userrole' => '3',
            'adminrole' => '2',
            'language' => 'tr',
            'timezone' => 'Europe/Istanbul',
            'date' => 'd/m/Y',
            'time' => 'H:i'
        ];

        foreach ($default_values as $key => $value) {
            $settings = Settings::create([
                'key' => $key,
                'value' => $value
            ]);
        }
    }
}
