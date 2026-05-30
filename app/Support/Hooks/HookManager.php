<?php

declare(strict_types=1);

namespace App\Support\Hooks;

/**
 * Modüllerin çekirdeğe katkı verdiği genişleme noktası tetikleyicisi.
 *
 * İki tür hook vardır:
 *  - action: bir noktada yan etki çalıştırır (`do`), dönüş değeri yoktur.
 *  - filter: bir değeri zincirleme dönüştürür (`apply`), dönüş değeri vardır.
 *
 * Callback'ler container ile çözülür (`app()->call`), bu yüzden bağımlılıkları
 * type-hint ederek alabilirler. Öncelik (priority) küçükten büyüğe çalışır.
 */
final class HookManager
{
    /**
     * @var array<string, array<int, array<int, callable>>>
     */
    private array $actions = [];

    /**
     * @var array<string, array<int, array<int, callable>>>
     */
    private array $filters = [];

    public function action(string $hook, callable $callback, int $priority = 10): void
    {
        $this->actions[$hook][$priority][] = $callback;
    }

    public function filter(string $hook, callable $callback, int $priority = 10): void
    {
        $this->filters[$hook][$priority][] = $callback;
    }

    public function do(string $hook, mixed ...$args): void
    {
        foreach ($this->sorted($this->actions[$hook] ?? []) as $callback) {
            app()->call($callback, $args);
        }
    }

    public function apply(string $hook, mixed $value, mixed ...$args): mixed
    {
        foreach ($this->sorted($this->filters[$hook] ?? []) as $callback) {
            $value = app()->call($callback, ['value' => $value, ...$args]);
        }

        return $value;
    }

    public function hasActions(string $hook): bool
    {
        return ($this->actions[$hook] ?? []) !== [];
    }

    /**
     * @param  array<int, array<int, callable>>  $byPriority
     * @return array<int, callable>
     */
    private function sorted(array $byPriority): array
    {
        if ($byPriority === []) {
            return [];
        }

        ksort($byPriority);

        return array_merge(...array_values($byPriority));
    }
}
