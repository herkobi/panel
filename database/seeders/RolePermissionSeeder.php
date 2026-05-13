<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $registry = config('panel-permissions');

        DB::transaction(function () use ($registry): void {
            // 1. Tüm izinleri oluştur veya güncelle.
            $permissions = collect();
            foreach (array_keys($registry['permissions']) as $name) {
                $permissions->push(
                    Permission::query()->firstOrCreate([
                        'name' => $name,
                        'guard_name' => 'web',
                    ]),
                );
            }

            // 2. Sistem rollerini oluştur.
            foreach (array_keys($registry['system_roles']) as $roleName) {
                Role::query()->firstOrCreate([
                    'name' => $roleName,
                    'guard_name' => 'web',
                ]);
            }

            // 3. Super Admin'e tüm izinleri ver.
            /** @var Role $superAdmin */
            $superAdmin = Role::query()->where('name', 'Super Admin')->firstOrFail();
            $superAdmin->syncPermissions($permissions);

            // 4. Admin'e exclusion listesi dışındakileri ver.
            $excluded = $registry['admin_excluded_permissions'];
            $adminPermissions = $permissions->reject(
                fn (Permission $permission): bool => in_array($permission->name, $excluded, true),
            );

            /** @var Role $admin */
            $admin = Role::query()->where('name', 'Admin')->firstOrFail();
            $admin->syncPermissions($adminPermissions);
        });

        app()['cache']->forget(config('permission.cache.key'));
    }
}
