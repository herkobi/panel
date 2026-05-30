<?php

declare(strict_types=1);

namespace App\Support\Registry;

use App\Enums\UserType;
use App\Models\User;

/**
 * Sidebar menüsünün tipli builder'ı. Çekirdek ve modüller, ilgili alanın
 * (`panel` / `app`) `{area}.menu.register` hook'una bağlanıp buraya yazar.
 *
 * Menü, her istekte kullanıcıya göre yeniden kurulur: yetki kontrolünden geçen
 * öğeler `order`'a göre sıralanır, boş gruplar gizlenir. Sonuç `navigation`
 * paylaşılan prop'u olarak Inertia ile paylaşılır.
 */
final class MenuRegistry
{
    /**
     * @var array<string, bool>
     */
    private array $registeredAreas = [];

    /**
     * @var array<string, array<string, array<string, mixed>>>
     */
    private array $groups = [];

    public function group(string $area, string $key, string $label, int $order = 100): self
    {
        $this->groups[$area][$key] ??= [
            'key' => $key,
            'label' => $label,
            'order' => $order,
            'items' => [],
        ];

        // Var olan grubun etiketi/sırası güncellenebilsin.
        $this->groups[$area][$key]['label'] = $label;
        $this->groups[$area][$key]['order'] = $order;

        return $this;
    }

    /**
     * @param  array<string, mixed>  $item
     */
    public function add(string $area, string $group, array $item): self
    {
        if (! isset($item['key'])) {
            throw new \InvalidArgumentException('Menu item key is required.');
        }

        $this->groups[$area][$group] ??= [
            'key' => $group,
            'label' => ucfirst($group),
            'order' => 100,
            'items' => [],
        ];

        $this->groups[$area][$group]['items'][(string) $item['key']] = [
            'order' => 100,
            'permission' => null,
            'icon' => null,
            'href' => '#',
            'items' => [],
            ...$item,
        ];

        return $this;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function forUser(?User $user): array
    {
        $area = $this->areaForUser($user);

        if ($area === null) {
            return [];
        }

        return $this->forArea($area, $user);
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function forArea(string $area, ?User $user): array
    {
        $this->registerArea($area);

        return collect($this->groups[$area] ?? [])
            ->sortBy('order')
            ->map(function (array $group) use ($user): array {
                $group['items'] = collect($group['items'] ?? [])
                    ->map(fn (array $item): ?array => $this->buildAuthorizedItem($item, $user))
                    ->filter()
                    ->sortBy('order')
                    ->values()
                    ->all();

                return $group;
            })
            ->filter(fn (array $group): bool => count($group['items']) > 0)
            ->values()
            ->all();
    }

    private function registerArea(string $area): void
    {
        if (($this->registeredAreas[$area] ?? false) === true) {
            return;
        }

        $this->registeredAreas[$area] = true;

        hooks()->do("{$area}.menu.register", $this);
    }

    private function areaForUser(?User $user): ?string
    {
        if ($user === null) {
            return null;
        }

        return $user->user_type === UserType::Admin ? 'panel' : 'app';
    }

    /**
     * @param  array<string, mixed>  $item
     * @return array<string, mixed>|null
     */
    private function buildAuthorizedItem(array $item, ?User $user): ?array
    {
        $children = collect($item['items'] ?? [])
            ->map(fn (array $child): ?array => $this->buildAuthorizedItem($child, $user))
            ->filter()
            ->sortBy('order')
            ->values()
            ->all();

        $permission = $item['permission'] ?? null;
        $isAuthorized = $permission === null || $permission === '' || $user?->can($permission) === true;

        // Yetkisiz ve görünür alt öğesi olmayan dal gizlenir.
        if (! $isAuthorized && count($children) === 0) {
            return null;
        }

        return [
            'key' => $item['key'],
            'title' => $item['title'],
            'href' => $item['href'] ?? '#',
            'icon' => $item['icon'] ?? null,
            'permission' => $permission,
            'order' => $item['order'] ?? 100,
            'items' => $children,
        ];
    }
}
