<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Permission;
use App\Support\Modules\ModuleDiscovery;
use App\Support\Modules\ModuleManifest;
use App\Support\Registry\PermissionRegistry;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Spatie\Permission\PermissionRegistrar;

/**
 * Bir modülü kurar: module.json'a göre ön yüz/mail dosyalarını publish eder,
 * migration'ları çalıştırır, yetkileri DB'ye seed eder (role atamadan) ve varsa
 * modülün Installer::installed() kancasını çağırır.
 *
 * Akış: composer require → herkobi:install → npm run build.
 */
final class InstallModuleCommand extends Command
{
    protected $signature = 'herkobi:install {module : Modül anahtarı (module.json key)} {--force : Var olan dosyaların üzerine yaz}';

    protected $description = 'Bir Herkobi modülünü kurar (publish + migrate + yetki seed).';

    public function handle(ModuleDiscovery $discovery, PermissionRegistry $permissions): int
    {
        $key = (string) $this->argument('module');
        $manifest = $discovery->find($key);

        if ($manifest === null) {
            $this->error("Modül bulunamadı: {$key}. Önce `composer require` ile kurun.");

            return self::FAILURE;
        }

        $this->info("Kuruluyor: {$manifest->name} v{$manifest->version}");

        $this->detectConflicts($manifest, $permissions);
        $this->publishFiles($manifest);

        if ($manifest->migrate) {
            $this->components->task('Migration çalıştırılıyor', function (): void {
                Artisan::call('migrate', ['--force' => true]);
            });
        }

        $this->seedPermissions($key, $permissions);
        $this->runInstaller($manifest, 'installed');

        $this->newLine();
        $this->info("✓ {$manifest->name} kuruldu.");
        $this->comment('Ön yüz dosyalarını derlemek için: npm run build');

        return self::SUCCESS;
    }

    private function detectConflicts(ModuleManifest $manifest, PermissionRegistry $permissions): void
    {
        $names = collect($permissions->forSource($manifest->key))->pluck('name');
        $existing = Permission::withTrashed()->whereIn('name', $names)->pluck('name');

        foreach ($existing as $name) {
            $this->warn("Yetki zaten mevcut, atlanacak: {$name}");
        }
    }

    private function publishFiles(ModuleManifest $manifest): void
    {
        $base = $manifest->basePath();

        if ($base === null) {
            return;
        }

        foreach ($manifest->publish as $entry) {
            $from = $this->safePath($base, $entry['from']);
            $to = $this->safePath(base_path(), $entry['to']);

            if ($from === null || $to === null) {
                $this->warn("Geçersiz yol atlandı: {$entry['from']} → {$entry['to']}");

                continue;
            }

            if (! File::exists($from)) {
                $this->warn("Kaynak yok, atlandı: {$entry['from']}");

                continue;
            }

            if (File::exists($to) && ! $this->option('force')
                && ! $this->confirm("Hedef var: {$entry['to']} — üzerine yazılsın mı?", false)) {
                $this->line("Atlandı: {$entry['to']}");

                continue;
            }

            if (File::isDirectory($from)) {
                File::ensureDirectoryExists($to);
                File::copyDirectory($from, $to);
            } else {
                File::ensureDirectoryExists(dirname($to));
                File::copy($from, $to);
            }

            $this->line("Publish: {$entry['to']}");
        }
    }

    private function seedPermissions(string $key, PermissionRegistry $permissions): void
    {
        $created = 0;

        foreach ($permissions->forSource($key) as $permission) {
            $exists = Permission::withTrashed()->where('name', $permission['name'])->exists();

            if ($exists) {
                continue;
            }

            Permission::query()->create([
                'name' => $permission['name'],
                'guard_name' => 'web',
                'group' => $permission['group'],
                'label' => $permission['label'],
            ]);

            $created++;
        }

        if ($created > 0) {
            app(PermissionRegistrar::class)->forgetCachedPermissions();
            $this->line("Yetki seed edildi: {$created} adet (rollere atanmadı).");
        }
    }

    private function runInstaller(ModuleManifest $manifest, string $method): void
    {
        $class = $this->installerClass($manifest);

        if ($class === null || ! method_exists($class, $method)) {
            return;
        }

        app()->call([app($class), $method]);
        $this->line("Installer::{$method}() çalıştırıldı.");
    }

    private function installerClass(ModuleManifest $manifest): ?string
    {
        $namespace = Str::beforeLast($manifest->provider, '\\');
        $class = $namespace.'\\'.Str::studly($manifest->key).'Installer';

        return class_exists($class) ? $class : null;
    }

    /**
     * Göreli yolu kök altında güvenle çözer; kök dışına (`../`) çıkarsa null.
     */
    private function safePath(string $root, string $relative): ?string
    {
        $resolved = $root.DIRECTORY_SEPARATOR.ltrim($relative, '/\\');
        $normalizedRoot = rtrim(str_replace('\\', '/', $root), '/');
        $normalized = str_replace('\\', '/', $resolved);

        if (! str_starts_with($normalized, $normalizedRoot.'/')) {
            return null;
        }

        return $resolved;
    }
}
