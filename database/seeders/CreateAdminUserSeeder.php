<?php

namespace Database\Seeders;

use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'type' => 1,
            'status' => UserStatus::ACTIVE,
            'name' => 'bülent',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'created_by' => 1,
            'created_by_name' => 'Super Admin',
            'terms' => 1
        ]);

        $role = Role::create(['name' => 'Admin', 'type' => UserType::ADMIN, 'desc' => 'Yönetici rolü', 'guard_name' => 'web']);
        $permissions = ['1', '2', '3', '4', '9', '10', '11', '12'];
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
