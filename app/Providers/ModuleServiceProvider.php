<?php

declare(strict_types=1);

namespace App\Providers;

use App\Support\Hooks\HookManager;
use App\Support\Modules\ModuleDiscovery;
use App\Support\Registry\MenuRegistry;
use App\Support\Registry\PermissionRegistry;
use Illuminate\Support\ServiceProvider;

/**
 * Modül altyapısının çekirdek sağlayıcısı.
 *
 * - Hook yöneticisini ve registry'leri singleton olarak bağlar.
 * - Çekirdeğin kendi menüsünü, tıpkı bir modül gibi, `{area}.menu.register`
 *   hook'una bağlayarak kaydeder (modüllere örnek teşkil eder).
 *
 * Modüller kendi provider'larında aynı hook'lara bağlanarak menü/yetki/rota
 * ekler. Hook callback'leri `register()` içinde kaydedilmelidir; böylece
 * çekirdek tetiklemeden (örn. rota yüklemesi) önce hazır olurlar.
 */
final class ModuleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(HookManager::class);
        $this->app->singleton(MenuRegistry::class);
        $this->app->singleton(PermissionRegistry::class);
        $this->app->singleton(ModuleDiscovery::class);

        hooks()->action('panel.menu.register', $this->registerPanelMenu(...));
        hooks()->action('app.menu.register', $this->registerAppMenu(...));
    }

    public function registerPanelMenu(MenuRegistry $menu): void
    {
        $menu->group('panel', 'platform', 'Platform', 10);
        $menu->group('panel', 'tools', 'Araçlar', 20);
        $menu->group('panel', 'settings', 'Ayarlar', 30);

        $menu->add('panel', 'platform', [
            'key' => 'panel.dashboard',
            'title' => 'Başlangıç',
            'href' => route('panel.dashboard'),
            'icon' => 'layoutGrid',
            'order' => 10,
        ]);

        $menu->add('panel', 'platform', [
            'key' => 'panel.members',
            'title' => 'Üyeler',
            'href' => '#',
            'icon' => 'users',
            'permission' => 'panel.members.index',
            'order' => 20,
            'items' => [
                [
                    'key' => 'panel.members.index',
                    'title' => 'Üyeler',
                    'href' => route('panel.members.index'),
                    'permission' => 'panel.members.index',
                    'order' => 10,
                ],
                [
                    'key' => 'panel.members.create',
                    'title' => 'Yeni Üye',
                    'href' => route('panel.members.create'),
                    'permission' => 'panel.members.create',
                    'order' => 20,
                ],
            ],
        ]);

        $menu->add('panel', 'tools', [
            'key' => 'panel.tools.activity',
            'title' => 'Etkinlik Kayıtları',
            'href' => route('panel.tools.activity'),
            'icon' => 'activity',
            'permission' => 'panel.tools.activity',
            'order' => 10,
        ]);

        $menu->add('panel', 'tools', [
            'key' => 'panel.tools.cache',
            'title' => 'Ön Bellek Yönetimi',
            'href' => route('panel.tools.cache'),
            'icon' => 'scanText',
            'permission' => 'panel.tools.cache',
            'order' => 20,
        ]);

        $menu->add('panel', 'tools', [
            'key' => 'panel.tools.definitions',
            'title' => 'Tanımlamalar',
            'href' => '#',
            'icon' => 'bookMarked',
            'permission' => 'panel.tools.definitions.languages.index',
            'order' => 30,
            'items' => [
                [
                    'key' => 'panel.tools.definitions.languages.index',
                    'title' => 'Diller',
                    'href' => route('panel.tools.definitions.languages.index'),
                    'permission' => 'panel.tools.definitions.languages.index',
                    'order' => 10,
                ],
                [
                    'key' => 'panel.tools.definitions.countries.index',
                    'title' => 'Bölgeler',
                    'href' => route('panel.tools.definitions.countries.index'),
                    'permission' => 'panel.tools.definitions.countries.index',
                    'order' => 20,
                ],
                [
                    'key' => 'panel.tools.definitions.currencies.index',
                    'title' => 'Para Birimleri',
                    'href' => route('panel.tools.definitions.currencies.index'),
                    'permission' => 'panel.tools.definitions.currencies.index',
                    'order' => 30,
                ],
                [
                    'key' => 'panel.tools.definitions.taxes.index',
                    'title' => 'Vergi Oranları',
                    'href' => route('panel.tools.definitions.taxes.index'),
                    'permission' => 'panel.tools.definitions.taxes.index',
                    'order' => 40,
                ],
            ],
        ]);

        $menu->add('panel', 'settings', [
            'key' => 'panel.settings.general',
            'title' => 'Genel Ayarlar',
            'href' => route('panel.settings.general.edit'),
            'icon' => 'bolt',
            'permission' => 'panel.settings.general.edit',
            'order' => 10,
        ]);

        $menu->add('panel', 'settings', [
            'key' => 'panel.settings.users',
            'title' => 'Kullanıcılar',
            'href' => '#',
            'icon' => 'squareUser',
            'permission' => 'panel.settings.users.index',
            'order' => 20,
            'items' => [
                [
                    'key' => 'panel.settings.users.index',
                    'title' => 'Kullanıcılar',
                    'href' => route('panel.settings.users.index'),
                    'permission' => 'panel.settings.users.index',
                    'order' => 10,
                ],
                [
                    'key' => 'panel.settings.users.create',
                    'title' => 'Kullanıcı Ekle',
                    'href' => route('panel.settings.users.create'),
                    'permission' => 'panel.settings.users.create',
                    'order' => 20,
                ],
                [
                    'key' => 'panel.settings.roles.index',
                    'title' => 'Roller',
                    'href' => route('panel.settings.roles.index'),
                    'permission' => 'panel.settings.roles.index',
                    'order' => 30,
                ],
                [
                    'key' => 'panel.settings.permissions.index',
                    'title' => 'Yetkiler',
                    'href' => route('panel.settings.permissions.index'),
                    'permission' => 'panel.settings.permissions.index',
                    'order' => 40,
                ],
            ],
        ]);
    }

    public function registerAppMenu(MenuRegistry $menu): void
    {
        $menu->group('app', 'platform', 'Platform', 10);

        $menu->add('app', 'platform', [
            'key' => 'app.dashboard',
            'title' => 'Başlangıç',
            'href' => route('app.dashboard'),
            'icon' => 'layoutGrid',
            'order' => 10,
        ]);

        $menu->add('app', 'platform', [
            'key' => 'app.account',
            'title' => 'Hesabım',
            'href' => '#',
            'icon' => 'userRound',
            'order' => 20,
            'items' => [
                [
                    'key' => 'app.account',
                    'title' => 'Hesabım',
                    'href' => route('app.account'),
                    'order' => 10,
                ],
            ],
        ]);
    }
}
