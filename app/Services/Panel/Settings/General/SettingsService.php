<?php

declare(strict_types=1);

namespace App\Services\Panel\Settings\General;

use App\Events\Panel\Settings\General\SettingsUpdatedEvent;
use App\Models\Setting;
use App\Models\User;
use App\Services\Support\FileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class SettingsService
{
    public const GROUP_GENERAL = 'general';

    public const GROUP_BRANDING = 'branding';

    public const GROUP_DEFAULTS = 'defaults';

    public const PANEL_DIRECTORY = 'panel';

    public const KEYS = [
        'app_name' => self::GROUP_GENERAL,
        'app_slogan' => self::GROUP_GENERAL,
        'logo_path' => self::GROUP_BRANDING,
        'logo_dark_path' => self::GROUP_BRANDING,
        'favicon_path' => self::GROUP_BRANDING,
        'default_country_id' => self::GROUP_DEFAULTS,
        'default_currency_id' => self::GROUP_DEFAULTS,
        'default_tax_id' => self::GROUP_DEFAULTS,
        'default_language_code' => self::GROUP_DEFAULTS,
        'default_timezone' => self::GROUP_DEFAULTS,
    ];

    public const FILE_KEYS = [
        'logo_path' => 'logo',
        'logo_dark_path' => 'logo-dark',
        'favicon_path' => 'favicon',
    ];

    public function __construct(
        private readonly FileService $files,
    ) {}

    /**
     * @return array<string, string|null>
     */
    public function all(): array
    {
        $values = Setting::allCached();

        $result = [];
        foreach (array_keys(self::KEYS) as $key) {
            $result[$key] = $values[$key] ?? null;
        }

        foreach (array_keys(self::FILE_KEYS) as $key) {
            $result[str_replace('_path', '_url', $key)] = $this->files->publicUrl($result[$key]);
        }

        return $result;
    }

    /**
     * @param  array<string, mixed>  $values
     */
    public function update(array $values, User $causer): void
    {
        $values = $this->storeUploadedFiles($values);

        DB::transaction(function () use ($values) {
            foreach ($values as $key => $value) {
                if (! array_key_exists($key, self::KEYS)) {
                    continue;
                }

                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value, 'group' => self::KEYS[$key]],
                );
            }
        });

        SettingsUpdatedEvent::dispatch($causer);
    }

    /**
     * @param  array<string, mixed>  $values
     * @return array<string, string|null>
     */
    private function storeUploadedFiles(array $values): array
    {
        $current = Setting::allCached();

        foreach (self::FILE_KEYS as $key => $prefix) {
            if (! ($values[$key] ?? null) instanceof UploadedFile) {
                unset($values[$key]);

                continue;
            }

            $values[$key] = $this->files->storePublicImage(
                $values[$key],
                self::PANEL_DIRECTORY,
                $current[$key] ?? null,
                $prefix,
            );
        }

        return $values;
    }
}
