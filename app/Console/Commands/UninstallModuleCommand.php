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
 * Bir modülü kaldırır (install'ın tersi). Güvenli varsayılan: yalnızca
 * değiştirilmemiş publish dosyalarını siler, veriye/tablolara dokunmaz.
 *
 * `--purge-data` verilirse migration'lar geri alınır. Yetki davranışı
 * module.json'daki `permissions` (`remove` | `keep`) ile belirlenir; silme
 * öncesi etkilenen roller raporlanır ve onay istenir.
 *
 * ÖNEMLİ: `composer remove`'dan ÖNCE çalıştırın; manifest hâlâ okunabilir olmalı.
 */
final class UninstallModuleCommand extends Command
{
    protected $signature = 'herkobi:uninstall {module : Modül anahtarı (module.json key)} {--force : Onay sormadan ilerle} {--purge-data : Migration\'ları geri al (veri kaybı)}';

    protected $description = 'Bir Herkobi modülünü kaldırır (publish geri al + opsiyonel veri temizliği).';

    public function handle(ModuleDiscovery $discovery, PermissionRegistry $permissions): int
    {
        $key = (string) $this->argument('module');
        $manifest = $discovery->find($key);

        if ($manifest === null) {
            $this->error("Modül bulunamadı: {$key}. Manifest hâlâ erişilebilir olmalı (composer remove'dan ÖNCE çalıştırın).");

            return self::FAILURE;
        }

        $this->info("Kaldırılıyor: {$manifest->name}");

        $this->runInstaller($manifest, 'uninstalling');
        $this->removePublishedFiles($manifest);

        if ($manifest->permissions === 'remove') {
            $this->removePermissions($key, $permissions);
        }

        if ($this->option('purge-data')) {
            $this->purgeData($manifest);
        } else {
            $this->comment('Veri/tablolar korundu. Silmek için: --purge-data');
        }

        $this->newLine();
        $this->info("✓ {$manifest->name} kaldırıldı. Artık `composer remove` çalıştırabilirsiniz.");

        return self::SUCCESS;
    }

    private function removePublishedFiles(ModuleManifest $manifest): void
    {
        $base = $manifest->basePath();

        if ($base === null) {
            return;
        }

        foreach ($manifest->publish as $entry) {
            $from = $this->safePath($base, $entry['from']);
            $to = $this->safePath(base_path(), $entry['to']);

            if ($from === null || $to === null || ! File::exists($to)) {
                continue;
            }

            $modified = $this->removeUnmodified($from, $to);

            if ($modified > 0) {
                $this->warn("{$entry['to']}: {$modified} düzenlenmiş dosya korundu (elle silin).");
            } else {
                $this->line("Kaldırıldı: {$entry['to']}");
            }
        }
    }

    /**
     * Hedefteki dosyalardan kaynakla birebir aynı olanları siler; düzenlenmiş
     * olanları bırakır. Geriye kalan düzenlenmiş dosya sayısını döndürür.
     */
    private function removeUnmodified(string $from, string $to): int
    {
        if (File::isFile($to)) {
            if (File::isFile($from) && md5_file($from) === md5_file($to)) {
                File::delete($to);

                return 0;
            }

            return 1;
        }

        $kept = 0;

        foreach (File::allFiles($to) as $file) {
            $relative = $file->getRelativePathname();
            $source = $from.DIRECTORY_SEPARATOR.$relative;

            if (File::isFile($source) && md5_file($source) === md5_file($file->getPathname())) {
                File::delete($file->getPathname());
            } else {
                $kept++;
            }
        }

        if ($kept === 0) {
            File::deleteDirectory($to);
        }

        return $kept;
    }

    private function removePermissions(string $key, PermissionRegistry $permissions): void
    {
        $names = collect($permissions->forSource($key))->pluck('name');
        $rows = Permission::withTrashed()->whereIn('name', $names)->withCount('roles')->get();

        if ($rows->isEmpty()) {
            return;
        }

        $affectedRoles = (int) $rows->sum('roles_count');

        if ($affectedRoles > 0 && ! $this->option('force')) {
            $this->warn("{$rows->count()} yetki silinecek; {$affectedRoles} rol ataması düşecek.");

            if (! $this->confirm('Devam edilsin mi?', false)) {
                $this->line('Yetki silme atlandı.');

                return;
            }
        }

        $rows->each(fn (Permission $permission) => $permission->forceDelete());
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $this->line("Yetki silindi: {$rows->count()} adet.");
    }

    private function purgeData(ModuleManifest $manifest): void
    {
        if (! $manifest->migrate || $manifest->basePath() === null) {
            return;
        }

        $migrations = $manifest->basePath().DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.'migrations';

        if (! File::isDirectory($migrations)) {
            $this->warn('Migration dizini bulunamadı; veri temizliği için Installer::uninstalling() kullanın.');

            return;
        }

        $this->components->task('Migration geri alınıyor (--purge-data)', function () use ($migrations): void {
            Artisan::call('migrate:rollback', [
                '--realpath' => true,
                '--path' => $migrations,
                '--force' => true,
            ]);
        });
    }

    private function runInstaller(ModuleManifest $manifest, string $method): void
    {
        $namespace = Str::beforeLast($manifest->provider, '\\');
        $class = $namespace.'\\'.Str::studly($manifest->key).'Installer';

        if (! class_exists($class) || ! method_exists($class, $method)) {
            return;
        }

        app()->call([app($class), $method]);
        $this->line("Installer::{$method}() çalıştırıldı.");
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
