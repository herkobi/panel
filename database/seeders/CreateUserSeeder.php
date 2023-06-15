<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
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
            'status' => UserStatus::ACTIVE,
            'name' => 'bülent',
            'email' => 'user@user.com',
            'password' => bcrypt('password'),
            'created_by' => 1,
            'created_by_name' => 'Super Admin',
            'terms' => 1
        ]);

        $role = Role::create(['name' => 'User', 'type' => UserType::USER, 'desc' => 'Kullanıcı rolü', 'guard_name' => 'web']);
        $user->assignRole([$role->id]);
    }
}
