<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            [
                'role-list',
                1,
                'Listeleme'
            ],
            [
                'role-create',
                1,
                'Ekleme'
            ],
            [
                'role-edit',
                1,
                'Güncelleme'
            ],
            [
                'role-delete',
                1,
                'Silme'
            ],
            [
                'admin-list',
                2,
                'Listeleme'
            ],
            [
                'admin-create',
                2,
                'Ekleme'
            ],
            [
                'admin-edit',
                2,
                'Güncelleme'
            ],
            [
                'admin-delete',
                2,
                'Silme'
            ],
            [
                'user-list',
                3,
                'Listeleme'
            ],
            [
                'user-create',
                3,
                'Ekleme'
            ],
            [
                'user-edit',
                3,
                'Güncelleme'
            ],
            [
                'user-delete',
                3,
                'Silme'
            ]
         ];

         foreach ($permissions as $permission) {
            Permission::create(['name' => $permission[0], 'group_id' => $permission[1], 'text' => $permission[2]]);
         }
    }
}
