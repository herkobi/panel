<?php

declare(strict_types=1);

namespace App\Services\Panel\Settings\Permissions;

use App\Models\Permission;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class PermissionService
{
    /**
     * Tüm izinleri group alanına göre grupla. UI tablosu için kullanılır.
     *
     * @return array<string, array<int, array{uuid: string, name: string, group: ?string, label: ?string, roles_count: int}>>
     */
    public function grouped(): array
    {
        $permissions = Permission::query()
            ->withCount('roles')
            ->orderBy('group')
            ->orderBy('name')
            ->get();

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

    /**
     * Panel rotalarından henüz DB'de izin satırı olmayanları listele.
     *
     * @return Collection<int, array{name: string, suggested_group: string, suggested_label: string}>
     */
    public function discoverableRoutes(): Collection
    {
        $existing = Permission::query()->pluck('name')->all();
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
    public function create(array $data): Permission
    {
        return DB::transaction(fn () => Permission::query()->create([
            'name' => $data['name'],
            'guard_name' => 'web',
            'group' => $data['group'] ?? null,
            'label' => $data['label'] ?? null,
        ]));
    }

    /**
     * @param  array{group?: ?string, label?: ?string}  $data
     */
    public function update(Permission $permission, array $data): Permission
    {
        return DB::transaction(function () use ($permission, $data): Permission {
            $permission->update([
                'group' => array_key_exists('group', $data) ? $data['group'] : $permission->group,
                'label' => array_key_exists('label', $data) ? $data['label'] : $permission->label,
            ]);

            return $permission->refresh();
        });
    }

    public function delete(Permission $permission): void
    {
        DB::transaction(fn () => $permission->delete());
    }

    /**
     * Discover sayfasından gelen rota adlarını toplu DB'ye yaz.
     *
     * @param  array<int, string>  $names
     * @return int Eklenen kayıt sayısı
     */
    public function bulkCreate(array $names): int
    {
        $existing = Permission::query()->whereIn('name', $names)->pluck('name')->all();
        $existingFlip = array_flip($existing);

        $created = 0;

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

                $created++;
            }
        });

        return $created;
    }

    /**
     * `panel.tools.definitions.units.index` → "Tanımlamalar / Birimler"
     * Basit heuristik: ilk üç segmentten okunabilir bir grup üret.
     */
    private function suggestGroup(string $name): string
    {
        $segments = explode('.', $name);

        // panel.tools.definitions.units.index → segments[2,3] => "Definitions / Units"
        // panel.settings.users.store         → segments[1,2] => "Settings / Users"
        $relevant = array_slice($segments, 1, 3);

        // Son segment fiilse onu at (index, store, vb.).
        $verbs = ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy', 'status', 'deleted', 'restore', 'force-delete', 'clear', 'verify', 'change', 'confirm', 'welcome', 'role', 'discover'];
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
        ];

        $segments = explode('.', $name);
        $last = end($segments);

        return $verbMap[$last] ?? ucfirst(str_replace(['-', '_'], ' ', $last));
    }
}
