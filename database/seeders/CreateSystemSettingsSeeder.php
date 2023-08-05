<?php

namespace Database\Seeders;

use App\Models\Settings;
use App\Models\User;
use Illuminate\Database\Seeder;

class CreateSystemSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $default_values = [
            'usersettings' => '0',
            'userrole' => '3',
            'adminrole' => '2',
            'language' => 'tr',
            'timezone' => 'Europe/Istanbul',
            'date' => 'd/m/Y',
            'time' => 'H:i'
        ];

        $default_user_values = [
            'language' => 'tr',
            'timezone' => 'Europe/Istanbul',
            'date' => 'd/m/Y',
            'time' => 'H:i'
        ];

        $user_settings = json_encode($default_user_values);
        $users = User::all();

        foreach ($default_values as $key => $value) {
            $settings = Settings::create([
                'key' => $key,
                'value' => $value
            ]);
        }

        foreach ($users as $user) {
            $user->forceFill([
                'settings' => $user_settings
            ])->save();
        }
    }
}
