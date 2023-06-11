<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\Permissiongroup;
use Illuminate\Database\Seeder;

class PermissiongroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            [
                'Yönetici Yönetimi',
                UserType::ADMIN,
                'Yönetici yönetimi grubu'
            ],
            [
                'Yetki Yönetimi',
                UserType::ADMIN,
                'Yetki yönetimi grubu'
            ],
            [
                'İzin Yönetimi',
                UserType::ADMIN,
                'İzin yönetimi grubu'
            ],
            [
                'İzin Grubu Yönetimi',
                UserType::ADMIN,
                'İzin Grubu yönetimi grubu'
            ],
            [
                'Kullanıcı Yönetimi',
                UserType::ADMIN,
                'Kullanıcı yönetimi grubu'
            ],
            [
                'Ayarların Yönetimi',
                UserType::ADMIN,
                'Ayar yönetimi grubu'
            ]
        ];

         foreach ($groups as $group) {
            Permissiongroup::create(['name' => $group[0], 'type' => $group[1], 'desc' => $group[2]]);
         }
    }
}
