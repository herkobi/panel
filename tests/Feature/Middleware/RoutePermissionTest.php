<?php

declare(strict_types=1);

use App\Enums\UserType;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;

beforeEach(function () {
    // Sistem rollerini hazır et — admin@admin.com benzeri akışlar için.
    $this->seed(RolePermissionSeeder::class);
});

test('Super Admin bypasses Gate::before and reaches any panel route', function () {
    $superAdmin = User::factory()->admin()->create();

    $this->actingAs($superAdmin)
        ->get(route('panel.settings.permissions.index'))
        ->assertOk();
});

test('admin without Super Admin role and without the specific permission gets 403', function () {
    $admin = User::factory()
        ->state(['user_type' => UserType::Admin])
        ->create();
    // admin() factory'sini bilerek atladık; Super Admin rolü atanmadı.
    $admin->syncRoles([Role::query()->where('name', 'Admin')->firstOrFail()]);

    $this->actingAs($admin)
        ->get(route('panel.settings.permissions.index'))
        ->assertForbidden();
});

test('admin with the specific permission can access the matching route', function () {
    $admin = User::factory()
        ->state(['user_type' => UserType::Admin])
        ->create();
    $adminRole = Role::query()->where('name', 'Admin')->firstOrFail();
    $permission = Permission::query()->create([
        'name' => 'panel.settings.permissions.index',
        'guard_name' => 'web',
        'group' => 'Ayarlar / Permissions',
        'label' => 'Listele',
    ]);
    $adminRole->givePermissionTo($permission);
    $admin->syncRoles([$adminRole]);

    $this->actingAs($admin)
        ->get(route('panel.settings.permissions.index'))
        ->assertOk();
});

test('exempt route (dashboard) is reachable without any permission', function () {
    $admin = User::factory()
        ->state(['user_type' => UserType::Admin])
        ->create();
    // Hiç rol yok, hiç izin yok.

    $this->actingAs($admin)
        ->get(route('panel.dashboard'))
        ->assertOk();
});
