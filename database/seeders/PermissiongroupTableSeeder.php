<?php

namespace Database\Seeders;

use App\Models\Permissiongroup;
use Illuminate\Database\Seeder;

class PermissiongroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'Rol Yönetimi',
                'Rol yönetimi grubu'
            ],
            [
                'Yönetici Yönetimi',
                'Yönetici yönetimi grubu'
            ],
            [
                'Kullanıcı Yönetimi',
                'Kullanıcı yönetimi grubu'
            ]
        ];

         foreach ($permissions as $permission) {
            Permissiongroup::create(['name' => $permission[0], 'desc' => $permission[1]]);
         }
    }
}
