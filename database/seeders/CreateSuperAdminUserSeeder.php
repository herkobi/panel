<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateSuperAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'type' => 1,
            'status' => UserStatus::ACTIVE, 
            'is_super' => 1,
            'name' => 'bülent',
            'email' => 'super@super.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'created_by' => 0,
            'created_by_name' => 'Owner',
            'terms' => 1
        ]);

        $role = Role::create(['name' => 'Super Admin', 'type' => UserType::ADMIN, 'desc' => 'Süper yönetici rolü', 'guard_name' => 'web']);

        $user->assignRole([$role->id]);
    }
}
