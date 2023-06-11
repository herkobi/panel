<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'type' => 2,
            'is_super' => 0,
            'name' => 'bülent',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'terms' => 1
        ]);

        $role = Role::create(['name' => 'User', 'type' => UserType::USER, 'desc' => 'Kullanıcı rolü', 'guard_name' => 'web']);
        $user->assignRole([$role->id]);
    }
}
