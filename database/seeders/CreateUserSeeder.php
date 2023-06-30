<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Settings;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $default_settings = Settings::pluck('value', 'key')->toArray();
        //$default_settings = json_encode($default_settings, JSON_UNESCAPED_SLASHES);

        $user = User::create([
            'type' => 2,
            'status' => UserStatus::ACTIVE,
            'name' => 'Bülent Sakarya',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'settings' => $default_settings,
            'created_by' => 1,
            'created_by_name' => 'Super Admin',
            'terms' => 1
        ]);

        $role = Role::create(['name' => 'User', 'type' => UserType::USER, 'desc' => 'Kullanıcı rolü', 'guard_name' => 'web']);
        $user->assignRole([$role->id]);

        for ($i = 0; $i <= 10; $i++) {
            $user = User::create([
                'type' => 2,
                'status' => UserStatus::ACTIVE,
                'name' => 'bülent' . $i,
                'email' => 'user' . $i . '@user.com',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'settings' => $default_settings,
                'created_by' => 1,
                'created_by_name' => 'Super Admin',
                'terms' => 1
            ]);
            $user->assignRole([$role->id]);
        }
    }
}
