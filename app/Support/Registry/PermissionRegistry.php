<?php

declare(strict_types=1);

namespace App\Support\Registry;

/**
 * Modüllerin yetki tanımlarını bildirdiği tipli builder. Modüller ilgili alanın
 * `{area}.permissions.register` hook'una bağlanıp buraya yazar.
 *
 * İki tüketici vardır:
 *  - "Rotalardan Keşfet" ekranı: tüm registry yetkilerini aday listesine katar
 *    (modül `composer require` edilir edilmez görünür, install gerekmez).
 *  - `herkobi:install` / `herkobi:uninstall`: yetkileri kaynağa (`source` =
 *    modül anahtarı) göre süzüp DB'ye seed eder / DB'den siler.
 *
 * @phpstan-type PermissionEntry array{name: string, group: ?string, label: ?string, source: ?string}
 */
final class PermissionRegistry
{
    /**
     * @var array<string, bool>
     */
    private array $registeredAreas = [];

    /**
     * @var array<string, array<string, array{name: string, group: ?string, label: ?string, source: ?string}>>
     */
    private array $permissions = [];

    /**
     * @param  array{name: string, group?: ?string, label?: ?string, source?: ?string}  $permission
     */
    public function add(string $area, array $permission, ?string $source = null): self
    {
        if (! isset($permission['name'])) {
            throw new \InvalidArgumentException('Permission name is required.');
        }

        $this->permissions[$area][$permission['name']] = [
            'name' => $permission['name'],
            'group' => $permission['group'] ?? null,
            'label' => $permission['label'] ?? null,
            'source' => $permission['source'] ?? $source,
        ];

        return $this;
    }

    /**
     * @param  array<int, array{name: string, group?: ?string, label?: ?string, source?: ?string}>  $permissions
     */
    public function addMany(string $area, array $permissions, ?string $source = null): self
    {
        foreach ($permissions as $permission) {
            $this->add($area, $permission, $source);
        }

        return $this;
    }

    /**
     * @return array<int, array{name: string, group: ?string, label: ?string, source: ?string}>
     */
    public function forArea(string $area): array
    {
        $this->registerArea($area);

        return array_values($this->permissions[$area] ?? []);
    }

    /**
     * Tüm alanlardaki yetkiler (isme göre tekilleştirilmiş).
     *
     * @return array<int, array{name: string, group: ?string, label: ?string, source: ?string}>
     */
    public function all(): array
    {
        $this->registerArea('panel');
        $this->registerArea('app');

        return collect($this->permissions)
            ->flatMap(fn (array $permissions): array => array_values($permissions))
            ->unique('name')
            ->values()
            ->all();
    }

    /**
     * Belirli bir modülün (kaynağın) sahip olduğu yetkiler — install/uninstall için.
     *
     * @return array<int, array{name: string, group: ?string, label: ?string, source: ?string}>
     */
    public function forSource(string $source): array
    {
        return collect($this->all())
            ->filter(fn (array $permission): bool => $permission['source'] === $source)
            ->values()
            ->all();
    }

    private function registerArea(string $area): void
    {
        if (($this->registeredAreas[$area] ?? false) === true) {
            return;
        }

        $this->registeredAreas[$area] = true;

        hooks()->do("{$area}.permissions.register", $this);
    }
}
