<?php

declare(strict_types=1);

namespace App\Support\Modules;

use Illuminate\Support\Facades\File;

/**
 * Kurulu modülleri `module.json` dosyaları üzerinden keşfeder. Salt-okurdur:
 * provider boot etmez (onu Laravel auto-discovery yapar). Yalnızca install /
 * uninstall komutları ve ileride yapılacak "Modüller" ekranı için metadata sağlar.
 */
final class ModuleDiscovery
{
    /**
     * @return array<int, ModuleManifest>
     */
    public function all(): array
    {
        $manifests = [];

        foreach ($this->discoveryPaths() as $pattern) {
            foreach (File::glob($pattern) ?: [] as $file) {
                $manifest = $this->read($file);

                if ($manifest !== null) {
                    $manifests[$manifest->key] = $manifest;
                }
            }
        }

        return array_values($manifests);
    }

    public function find(string $key): ?ModuleManifest
    {
        foreach ($this->all() as $manifest) {
            if ($manifest->key === $key) {
                return $manifest;
            }
        }

        return null;
    }

    public function read(string $file): ?ModuleManifest
    {
        if (! is_file($file)) {
            return null;
        }

        $contents = file_get_contents($file);

        if ($contents === false) {
            return null;
        }

        $data = json_decode($contents, true);

        if (! is_array($data)) {
            throw new \RuntimeException("Invalid module manifest JSON: {$file}");
        }

        return ModuleManifest::fromArray($data, $file);
    }

    /**
     * @return array<int, string>
     */
    private function discoveryPaths(): array
    {
        /** @var array<int, string> $paths */
        $paths = config('herkobi.module_discovery_paths', []);

        return $paths;
    }
}
