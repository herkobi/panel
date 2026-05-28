<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Yetki sistemi UI-merkezli: izinler "Yetkiler" ekranından (manuel veya
     * "Rotalardan keşfet" butonu ile) eklenip rollere atanır. Seeder yalnızca
     * iki sistem rolünü hazır eder:
     *
     * - Super Admin: Gate::before ile TÜM yetkilere otomatik sahip; izin
     *   listesine eklenmez.
     * - Admin: boş başlar; ihtiyaç oldukça Super Admin bu role izin atar.
     */
    public function run(): void
    {
        Role::query()->firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'web']);
        Role::query()->firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);

        app()['cache']->forget(config('permission.cache.key'));
    }
}
