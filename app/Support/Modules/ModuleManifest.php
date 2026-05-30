<?php

declare(strict_types=1);

namespace App\Support\Modules;

/**
 * Bir modülün `module.json` dosyasının tipli karşılığı.
 *
 * `publish` haritası `{from, to}` çiftlerinden oluşur: `from` paket köküne,
 * `to` proje köküne görelidir. Lifecycle bayrakları install/uninstall
 * davranışını belirler (bkz. docs/modules.md).
 */
final readonly class ModuleManifest
{
    /**
     * @param  array<int, string>  $areas
     * @param  array<int, array{from: string, to: string}>  $publish
     * @param  array<string, mixed>  $author
     * @param  array<string, mixed>  $links
     * @param  array<string, mixed>  $requires
     */
    public function __construct(
        public string $key,
        public string $name,
        public ?string $description,
        public string $version,
        public string $provider,
        public array $areas = [],
        public array $publish = [],
        public bool $migrate = false,
        public string $permissions = 'keep',
        public bool $purgeData = false,
        public bool $enabled = true,
        public array $author = [],
        public array $links = [],
        public array $requires = [],
        public ?string $path = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data, ?string $path = null): self
    {
        foreach (['key', 'name', 'version', 'provider'] as $required) {
            if (! isset($data[$required]) || $data[$required] === '') {
                throw new \InvalidArgumentException("Module manifest missing required field: {$required}");
            }
        }

        return new self(
            key: (string) $data['key'],
            name: (string) $data['name'],
            description: isset($data['description']) ? (string) $data['description'] : null,
            version: (string) $data['version'],
            provider: (string) $data['provider'],
            areas: array_values(array_map('strval', $data['areas'] ?? [])),
            publish: self::normalizePublish($data['publish'] ?? []),
            migrate: (bool) ($data['migrate'] ?? false),
            permissions: in_array($data['permissions'] ?? 'keep', ['keep', 'remove'], true) ? (string) $data['permissions'] : 'keep',
            purgeData: (bool) ($data['purge_data'] ?? false),
            enabled: (bool) ($data['enabled'] ?? true),
            author: is_array($data['author'] ?? null) ? $data['author'] : [],
            links: is_array($data['links'] ?? null) ? $data['links'] : [],
            requires: is_array($data['requires'] ?? null) ? $data['requires'] : [],
            path: $path,
        );
    }

    /**
     * Modülün kök dizini (module.json'ın bulunduğu klasör).
     */
    public function basePath(): ?string
    {
        return $this->path === null ? null : dirname($this->path);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'key' => $this->key,
            'name' => $this->name,
            'description' => $this->description,
            'version' => $this->version,
            'provider' => $this->provider,
            'areas' => $this->areas,
            'publish' => $this->publish,
            'migrate' => $this->migrate,
            'permissions' => $this->permissions,
            'purge_data' => $this->purgeData,
            'enabled' => $this->enabled,
            'author' => $this->author,
            'links' => $this->links,
            'requires' => $this->requires,
            'path' => $this->path,
        ];
    }

    /**
     * @return array<int, array{from: string, to: string}>
     */
    private static function normalizePublish(mixed $publish): array
    {
        if (! is_array($publish)) {
            return [];
        }

        $normalized = [];

        foreach ($publish as $entry) {
            if (! is_array($entry) || ! isset($entry['from'], $entry['to'])) {
                continue;
            }

            $normalized[] = [
                'from' => (string) $entry['from'],
                'to' => (string) $entry['to'],
            ];
        }

        return $normalized;
    }
}
