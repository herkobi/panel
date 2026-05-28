<?php

declare(strict_types=1);

namespace App\Services\Panel\Settings\Permissions;

use App\Events\Panel\Settings\Permissions\PermissionCreatedEvent;
use App\Events\Panel\Settings\Permissions\PermissionDeletedEvent;
use App\Events\Panel\Settings\Permissions\PermissionForceDeletedEvent;
use App\Events\Panel\Settings\Permissions\PermissionRestoredEvent;
use App\Events\Panel\Settings\Permissions\PermissionsBulkAddedEvent;
use App\Events\Panel\Settings\Permissions\PermissionUpdatedEvent;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\PermissionRegistrar;

class PermissionService
{
    /**
     * Aktif izinleri group alanına göre grupla. Soft-deleted olanlar dahil değil.
     *
     * @return array<string, array<int, array{uuid: string, name: string, group: ?string, label: ?string, roles_count: int}>>
     */
    public function grouped(): array
    {
        return $this->groupPermissions(
            Permission::query()
                ->withCount('roles')
                ->orderBy('group')
                ->orderBy('name')
                ->get()
        );
    }

    /**
     * Soft-deleted izinleri group alanına göre grupla ("Silinenler" tabı için).
     *
     * @return array<string, array<int, array{uuid: string, name: string, group: ?string, label: ?string, roles_count: int}>>
     */
    public function deletedGrouped(): array
    {
        return $this->groupPermissions(
            Permission::onlyTrashed()
                ->withCount('roles')
                ->orderBy('group')
                ->orderBy('name')
                ->get()
        );
    }

    /**
     * Panel rotalarından henüz DB'de (aktif veya silinmiş) izin satırı olmayanları listele.
     *
     * @return Collection<int, array{name: string, suggested_group: string, suggested_label: string}>
     */
    public function discoverableRoutes(): Collection
    {
        $existing = Permission::withTrashed()->pluck('name')->all();
        $existingFlip = array_flip($existing);

        $candidates = collect(Route::getRoutes())
            ->map(fn ($route) => $route->getName())
            ->filter(fn ($name) => is_string($name) && str_starts_with($name, 'panel.'))
            ->unique()
            ->values();

        return $candidates
            ->reject(fn (string $name): bool => isset($existingFlip[$name]))
            ->map(fn (string $name): array => [
                'name' => $name,
                'suggested_group' => $this->suggestGroup($name),
                'suggested_label' => $this->suggestLabel($name),
            ])
            ->sortBy('name')
            ->values();
    }

    /**
     * @param  array{name: string, group?: ?string, label?: ?string}  $data
     */
    public function create(array $data, User $causer): Permission
    {
        $permission = DB::transaction(fn () => Permission::query()->create([
            'name' => $data['name'],
            'guard_name' => 'web',
            'group' => $data['group'] ?? null,
            'label' => $data['label'] ?? null,
        ]));

        $this->forgetPermissionCache();

        PermissionCreatedEvent::dispatch($permission, $causer);

        return $permission;
    }

    /**
     * @param  array{group?: ?string, label?: ?string}  $data
     */
    public function update(Permission $permission, array $data, User $causer): Permission
    {
        $changes = [];

        DB::transaction(function () use ($permission, $data, &$changes): void {
            foreach (['group', 'label'] as $field) {
                if (! array_key_exists($field, $data)) {
                    continue;
                }

                $newValue = $data[$field];

                if ($permission->{$field} === $newValue) {
                    continue;
                }

                $changes[$field] = ['from' => $permission->{$field}, 'to' => $newValue];
                $permission->{$field} = $newValue;
            }

            if ($changes !== []) {
                $permission->save();
            }
        });

        if ($changes !== []) {
            $this->forgetPermissionCache();

            PermissionUpdatedEvent::dispatch($permission->refresh(), $causer, $changes);
        }

        return $permission;
    }

    public function delete(Permission $permission, User $causer): void
    {
        DB::transaction(fn () => $permission->delete());

        $this->forgetPermissionCache();

        PermissionDeletedEvent::dispatch($permission, $causer);
    }

    public function restore(Permission $permission, User $causer): Permission
    {
        DB::transaction(fn () => $permission->restore());

        $this->forgetPermissionCache();

        PermissionRestoredEvent::dispatch($permission->refresh(), $causer);

        return $permission;
    }

    public function forceDelete(Permission $permission, User $causer): void
    {
        $name = $permission->name;

        DB::transaction(fn () => $permission->forceDelete());

        $this->forgetPermissionCache();

        PermissionForceDeletedEvent::dispatch($name, $causer);
    }

    /**
     * @param  array<int, string>  $names
     * @return int Eklenen kayıt sayısı
     */
    public function bulkCreate(array $names, User $causer): int
    {
        $existing = Permission::withTrashed()->whereIn('name', $names)->pluck('name')->all();
        $existingFlip = array_flip($existing);

        $created = [];

        DB::transaction(function () use ($names, $existingFlip, &$created): void {
            foreach ($names as $name) {
                if (isset($existingFlip[$name])) {
                    continue;
                }

                Permission::query()->create([
                    'name' => $name,
                    'guard_name' => 'web',
                    'group' => $this->suggestGroup($name),
                    'label' => $this->suggestLabel($name),
                ]);

                $created[] = $name;
            }
        });

        if ($created !== []) {
            $this->forgetPermissionCache();

            PermissionsBulkAddedEvent::dispatch($created, $causer);
        }

        return count($created);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Collection<int, Permission>  $permissions
     * @return array<string, array<int, array{uuid: string, name: string, group: ?string, label: ?string, roles_count: int}>>
     */
    private function groupPermissions($permissions): array
    {
        $groups = [];
        foreach ($permissions as $permission) {
            $key = $permission->group !== null && $permission->group !== ''
                ? $permission->group
                : 'Diğer';

            $groups[$key][] = [
                'uuid' => $permission->getKey(),
                'name' => $permission->name,
                'group' => $permission->group,
                'label' => $permission->label,
                'roles_count' => (int) $permission->roles_count,
            ];
        }

        ksort($groups);

        return $groups;
    }

    private function forgetPermissionCache(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }

    /**
     * `panel.tools.definitions.units.index` → "Tanımlamalar / Birimler"
     */
    private function suggestGroup(string $name): string
    {
        $segments = explode('.', $name);
        $relevant = array_slice($segments, 1, 3);

        $verbs = ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'status', 'deleted', 'restore', 'force-delete', 'clear', 'verify', 'change', 'confirm', 'welcome', 'role', 'discover', 'bulk-store'];
        if ($relevant !== [] && in_array(end($relevant), $verbs, true)) {
            array_pop($relevant);
        }

        return implode(' / ', array_map(fn ($s) => ucfirst(str_replace(['-', '_'], ' ', $s)), $relevant)) ?: 'Diğer';
    }

    /**
     * `panel.tools.definitions.units.index` → "Listele"
     */
    private function suggestLabel(string $name): string
    {
        $verbMap = [
            'index' => 'Listele',
            'create' => 'Oluşturma Formu',
            'store' => 'Oluştur',
            'show' => 'Detay',
            'edit' => 'Düzenleme Formu',
            'update' => 'Güncelle',
            'destroy' => 'Sil',
            'status' => 'Durum Değiştir',
            'deleted' => 'Silinenler',
            'restore' => 'Geri Yükle',
            'force-delete' => 'Kalıcı Sil',
            'clear' => 'Temizle',
            'verify' => 'Onayla',
            'change' => 'Değiştir',
            'confirm' => 'Onayla',
            'welcome' => 'Hoş Geldin',
            'role' => 'Rol Ata',
            'discover' => 'Keşfet',
            'bulk-store' => 'Toplu Ekle',
        ];

        $segments = explode('.', $name);
        $last = end($segments);

        return $verbMap[$last] ?? ucfirst(str_replace(['-', '_'], ' ', $last));
    }
}
