<?php

declare(strict_types=1);

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('admin can view the permissions list grouped by group column', function () {
    $admin = User::factory()->admin()->create();

    Permission::query()->create([
        'name' => 'panel.units.index',
        'guard_name' => 'web',
        'group' => 'Birimler',
        'label' => 'Listele',
    ]);

    $this->actingAs($admin)
        ->get(route('panel.settings.permissions.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('panel/settings/permissions/index')
            ->has('groups.Birimler', 1)
            ->where('groups.Birimler.0.name', 'panel.units.index')
            ->where('groups.Birimler.0.label', 'Listele')
        );
});

test('admin can create a permission manually', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('panel.settings.permissions.store'), [
            'name' => 'panel.payments.bulk_approve',
            'group' => 'Ödemeler',
            'label' => 'Toplu Onayla',
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('permissions', [
        'name' => 'panel.payments.bulk_approve',
        'group' => 'Ödemeler',
        'label' => 'Toplu Onayla',
    ]);
});

test('permission creation rejects invalid name format', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('panel.settings.permissions.store'), [
            'name' => 'Has Spaces And UpperCase',
        ])
        ->assertSessionHasErrors('name');
});

test('permission creation rejects duplicate name', function () {
    $admin = User::factory()->admin()->create();
    Permission::query()->create([
        'name' => 'panel.units.index',
        'guard_name' => 'web',
    ]);

    $this->actingAs($admin)
        ->post(route('panel.settings.permissions.store'), [
            'name' => 'panel.units.index',
        ])
        ->assertSessionHasErrors('name');
});

test('admin can update group and label without changing the name', function () {
    $admin = User::factory()->admin()->create();
    $permission = Permission::query()->create([
        'name' => 'panel.units.index',
        'guard_name' => 'web',
        'group' => 'Eski Grup',
        'label' => 'Eski Etiket',
    ]);

    $this->actingAs($admin)
        ->put(route('panel.settings.permissions.update', $permission), [
            'group' => 'Yeni Grup',
            'label' => 'Yeni Etiket',
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $permission->refresh();

    expect($permission->name)->toBe('panel.units.index')
        ->and($permission->group)->toBe('Yeni Grup')
        ->and($permission->label)->toBe('Yeni Etiket');
});

test('deleting a permission is soft delete (kept in DB with deleted_at)', function () {
    $admin = User::factory()->admin()->create();
    $permission = Permission::query()->create([
        'name' => 'panel.units.destroy',
        'guard_name' => 'web',
    ]);

    $this->actingAs($admin)
        ->delete(route('panel.settings.permissions.destroy', $permission))
        ->assertRedirect();

    expect(Permission::query()->where('name', 'panel.units.destroy')->exists())->toBeFalse()
        ->and(Permission::onlyTrashed()->where('name', 'panel.units.destroy')->exists())->toBeTrue();
});

test('soft-deleted permissions are listed on the deleted page', function () {
    $admin = User::factory()->admin()->create();
    $permission = Permission::query()->create([
        'name' => 'panel.units.legacy',
        'guard_name' => 'web',
        'group' => 'Eski',
        'label' => 'Eski etiket',
    ]);
    $permission->delete();

    $this->actingAs($admin)
        ->get(route('panel.settings.permissions.deleted'))
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('panel/settings/permissions/deleted')
            ->has('groups.Eski', 1)
            ->where('groups.Eski.0.name', 'panel.units.legacy')
        );
});

test('admin can restore a soft-deleted permission', function () {
    $admin = User::factory()->admin()->create();
    $permission = Permission::query()->create([
        'name' => 'panel.units.legacy',
        'guard_name' => 'web',
    ]);
    $permission->delete();

    $this->actingAs($admin)
        ->patch(route('panel.settings.permissions.restore', $permission->getKey()))
        ->assertRedirect();

    expect(Permission::query()->where('name', 'panel.units.legacy')->exists())->toBeTrue()
        ->and(Permission::onlyTrashed()->where('name', 'panel.units.legacy')->exists())->toBeFalse();
});

test('admin can permanently delete a soft-deleted permission', function () {
    $admin = User::factory()->admin()->create();
    $permission = Permission::query()->create([
        'name' => 'panel.units.legacy',
        'guard_name' => 'web',
    ]);
    $permission->delete();

    $this->actingAs($admin)
        ->delete(route('panel.settings.permissions.force-delete', $permission->getKey()))
        ->assertRedirect();

    expect(Permission::withTrashed()->where('name', 'panel.units.legacy')->exists())->toBeFalse();
});

test('restore route refuses non-trashed permissions', function () {
    $admin = User::factory()->admin()->create();
    $permission = Permission::query()->create([
        'name' => 'panel.units.active',
        'guard_name' => 'web',
    ]);

    $this->actingAs($admin)
        ->patch(route('panel.settings.permissions.restore', $permission->getKey()))
        ->assertNotFound();
});

test('activity log records permission lifecycle events', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('panel.settings.permissions.store'), [
            'name' => 'panel.units.index',
            'group' => 'Birimler',
            'label' => 'Listele',
        ])
        ->assertRedirect();

    $permission = Permission::query()->where('name', 'panel.units.index')->firstOrFail();

    $this->assertDatabaseHas('activity_log', [
        'log_name' => 'panel.permission',
        'event' => 'created',
        'causer_id' => $admin->id,
    ]);

    $this->actingAs($admin)
        ->put(route('panel.settings.permissions.update', $permission), [
            'group' => 'Yeni Birimler',
            'label' => 'Liste',
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('activity_log', [
        'log_name' => 'panel.permission',
        'event' => 'updated',
        'causer_id' => $admin->id,
    ]);

    $this->actingAs($admin)
        ->delete(route('panel.settings.permissions.destroy', $permission))
        ->assertRedirect();

    $this->assertDatabaseHas('activity_log', [
        'log_name' => 'panel.permission',
        'event' => 'deleted',
        'causer_id' => $admin->id,
    ]);

    $this->actingAs($admin)
        ->patch(route('panel.settings.permissions.restore', $permission->getKey()))
        ->assertRedirect();

    $this->assertDatabaseHas('activity_log', [
        'log_name' => 'panel.permission',
        'event' => 'restored',
        'causer_id' => $admin->id,
    ]);

    // force-delete için tekrar soft-delete yapmak gerek.
    $this->actingAs($admin)
        ->delete(route('panel.settings.permissions.destroy', $permission))
        ->assertRedirect();

    $this->actingAs($admin)
        ->delete(route('panel.settings.permissions.force-delete', $permission->getKey()))
        ->assertRedirect();

    $this->assertDatabaseHas('activity_log', [
        'log_name' => 'panel.permission',
        'event' => 'force_deleted',
        'causer_id' => $admin->id,
    ]);
});

test('bulk-store records a single bulk_added activity entry', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('panel.settings.permissions.bulk-store'), [
            'names' => [
                'panel.units.index',
                'panel.units.store',
            ],
        ])
        ->assertRedirect();

    $this->assertDatabaseHas('activity_log', [
        'log_name' => 'panel.permission',
        'event' => 'bulk_added',
        'causer_id' => $admin->id,
    ]);
});

test('discover page lists panel routes that have no permission row yet', function () {
    $admin = User::factory()->admin()->create();

    // Mevcut bir panel rotası için izin ekleyelim; discover bunu listelemez.
    Permission::query()->create([
        'name' => 'panel.dashboard',
        'guard_name' => 'web',
    ]);

    $this->actingAs($admin)
        ->get(route('panel.settings.permissions.discover'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('panel/settings/permissions/discover')
            ->has('routes')
            ->where('routes', function ($routes) {
                foreach ($routes as $route) {
                    expect($route['name'])->not->toBe('panel.dashboard');
                    expect($route['name'])->toStartWith('panel.');
                }

                return true;
            })
        );
});

test('bulk store creates only the selected permissions with derived group and label', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('panel.settings.permissions.bulk-store'), [
            'names' => [
                'panel.settings.permissions.index',
                'panel.settings.permissions.store',
            ],
        ])
        ->assertRedirect(route('panel.settings.permissions.index'));

    $created = Permission::query()
        ->whereIn('name', [
            'panel.settings.permissions.index',
            'panel.settings.permissions.store',
        ])
        ->get();

    expect($created)->toHaveCount(2)
        ->and($created->firstWhere('name', 'panel.settings.permissions.index')->label)->toBe('Listele')
        ->and($created->firstWhere('name', 'panel.settings.permissions.store')->label)->toBe('Oluştur');
});

test('bulk store is idempotent: existing permissions are not duplicated', function () {
    $admin = User::factory()->admin()->create();
    Permission::query()->create([
        'name' => 'panel.units.index',
        'guard_name' => 'web',
    ]);

    $this->actingAs($admin)
        ->post(route('panel.settings.permissions.bulk-store'), [
            'names' => ['panel.units.index'],
        ])
        ->assertRedirect();

    expect(Permission::query()->where('name', 'panel.units.index')->count())->toBe(1);
});

test('admin assigning permissions to a role works after permission name is curated', function () {
    $admin = User::factory()->admin()->create();
    $role = Role::query()->where('name', 'Admin')->firstOrFail();
    $permission = Permission::query()->create([
        'name' => 'panel.units.index',
        'guard_name' => 'web',
        'group' => 'Birimler',
        'label' => 'Listele',
    ]);

    $this->actingAs($admin)
        ->patch(route('panel.settings.roles.update', $role), [
            'permissions' => [$permission->name],
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    expect($role->fresh()->hasPermissionTo('panel.units.index'))->toBeTrue();
});

test('updating a system role permissions preserves its name', function () {
    // Sistem rolünde isim alanı disable; payload'a `name` gönderilmez.
    // Controller bu durumda ismi korumalı, boş stringe çekmemeli.
    $admin = User::factory()->admin()->create();
    $role = Role::query()->where('name', 'Admin')->firstOrFail();
    $permission = Permission::query()->create([
        'name' => 'panel.units.index',
        'guard_name' => 'web',
    ]);

    $this->actingAs($admin)
        ->patch(route('panel.settings.roles.update', $role), [
            'permissions' => [$permission->name],
        ])
        ->assertSessionHasNoErrors();

    expect($role->fresh()->name)->toBe('Admin');
});
