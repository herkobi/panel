<?php

declare(strict_types=1);

namespace App\Support\Modules;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use SplFileInfo;
use Symfony\Component\Finder\Finder;

/**
 * Modül listener'larını event'lerine bağlar.
 *
 * Çekirdek, listener'ları Laravel'in event auto-discovery'si ile bulur — ama o
 * mekanizma modül içinde çalışmaz: `DiscoverEvents::classFromFile()` sınıf adını
 * dosya yolundan türetirken "`app/` dizini = `App\` namespace'i" varsayar, paket
 * listener'ları bu kalıba uymaz ve türetilen ad tutmayınca `ReflectionException`
 * sessizce yutulur. Sonuç: dispatch edilen event'i dinleyen kimse olmaz.
 *
 * Bu yardımcı auto-discovery'nin DOĞRU olan kısmını (bir listener'ın `handle()`
 * parametresinden event tipini reflection ile okumak) korur, yalnızca kırık olan
 * kısmı değiştirir: sınıf adını dosya yolundan tahmin etmek yerine modülün kendi
 * verdiği namespace'ten kurar. Böylece modül, çekirdekle aynı "sıfır konfigürasyon
 * listener" deneyimini yaşar.
 *
 * Kullanım (modül provider'ının `register()`'ında):
 *
 *   ModuleListeners::discover(__DIR__.'/Listeners', 'Herkobi\\Service\\Listeners');
 *
 * `register()` içinde çağrılmalı — çekirdek event'leri dispatch etmeden önce
 * bağlanmaları için.
 */
final class ModuleListeners
{
    /**
     * Verilen dizindeki listener'ları tarar ve `handle*` / `__invoke`
     * metotlarının ilk parametresine göre event'lerine bağlar.
     *
     * @param  string  $directory  Listener sınıflarını içeren dizin (rekürsif taranır).
     * @param  string  $namespace  Bu dizinin kök namespace'i (sondaki `\` önemsiz).
     */
    public static function discover(string $directory, string $namespace): void
    {
        if (! is_dir($directory)) {
            return;
        }

        $namespace = trim($namespace, '\\');

        foreach (Finder::create()->files()->name('*.php')->in($directory) as $file) {
            $class = self::classFromFile($file, $directory, $namespace);

            try {
                $reflection = new ReflectionClass($class);
            } catch (ReflectionException) {
                continue;
            }

            if (! $reflection->isInstantiable()) {
                continue;
            }

            foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                if (! Str::is('handle*', $method->getName()) && $method->getName() !== '__invoke') {
                    continue;
                }

                $event = self::eventFromMethod($method);

                if ($event !== null) {
                    Event::listen($event, [$class, $method->getName()]);
                }
            }
        }
    }

    /**
     * Dosya yolundan tam sınıf adını, modülün namespace'ini kök alarak kurar.
     * (Laravel'in aksine `app/ = App\` varsaymaz.)
     */
    private static function classFromFile(SplFileInfo $file, string $directory, string $namespace): string
    {
        $relative = Str::of($file->getRealPath())
            ->after(realpath($directory))
            ->trim(DIRECTORY_SEPARATOR)
            ->replace(DIRECTORY_SEPARATOR, '\\')
            ->replaceLast('.php', '');

        return $namespace.'\\'.$relative;
    }

    /**
     * Bir metodun ilk parametresinin tip adını (dinlenecek event) döndürür;
     * tip yoksa null.
     */
    private static function eventFromMethod(ReflectionMethod $method): ?string
    {
        $parameters = $method->getParameters();

        if ($parameters === []) {
            return null;
        }

        $type = $parameters[0]->getType();

        if ($type instanceof \ReflectionNamedType && ! $type->isBuiltin()) {
            return $type->getName();
        }

        return null;
    }
}
