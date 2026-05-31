# Örnek: `todo` Modülü (baştan sona)

Bu sayfa, çekirdeği **hiç düzenlemeden** panele bir **Todo** ekranı ekleyen
gerçek bir modülü adım adım kurar. Amaç, sistemin **net ayrımını** göstermek:

> **Çekirdek** genişleme noktalarını (hook) tetikler ve tipli registry'leri sunar.
> **Modül** bir composer paketi olarak bu noktalara bağlanıp menü, rota, yetki ve
> ekran **katkısı** verir. İkisi arasından yalnızca tipli veri geçer; modül
> çekirdeğin iç detaylarına dokunmaz.

Tüm kodu okuyup geçmeden önce şu zihinsel haritayı tut:

| Katkı | Hangi hook | Hangi registry/API | Sonuç |
|---|---|---|---|
| Rota | `panel.routes.register` | `Route::...` | `/panel/...` + `panel.` adı + tam middleware |
| Menü | `panel.menu.register` | `MenuRegistry` | yetki-filtreli sidebar öğesi |
| Yetki | `panel.permissions.register` | `PermissionRegistry` | "Rotalardan Keşfet" + `herkobi:install` seed |
| Ekran | publish | `module.json` `publish` | `resources/js/pages/panel/todo/*` |

## 1. Paket iskeleti

Yerel geliştirme için kök `composer.json`'a bir **path repository** ekleyip modülü
`packages/` altında geliştirebilirsin (`config/herkobi.php` zaten
`packages/*/module.json` yolunu tarar).

```
packages/todo/
├─ composer.json
├─ module.json
├─ src/
│  ├─ TodoServiceProvider.php
│  ├─ Http/Controllers/TodoController.php
│  └─ TodoInstaller.php            # opsiyonel
├─ database/migrations/
│  └─ 2026_01_01_000000_create_todos_table.php
└─ resources/js/pages/panel/
   └─ index.tsx                    # publish edilecek ekran
```

Kök `composer.json`'a (yalnızca yerel geliştirme için):

```jsonc
{
  "repositories": [
    { "type": "path", "url": "packages/*", "options": { "symlink": true } }
  ]
}
```

Sonra: `composer require herkobi/todo:@dev`.

## 2. `composer.json` — auto-discovery

Provider'ı Laravel'in **otomatik keşfetmesi** için `extra.laravel.providers`
yeterlidir; çekirdek tarafında elle boot yoktur.

```jsonc
{
  "name": "herkobi/todo",
  "description": "Herkobi için Todo modülü.",
  "type": "library",
  "require": { "php": "^8.4" },
  "autoload": { "psr-4": { "Herkobi\\Todo\\": "src/" } },
  "extra": {
    "laravel": {
      "providers": ["Herkobi\\Todo\\TodoServiceProvider"]
    }
  }
}
```

::: tip Gerçek bağımlılık burada
Modülün başka bir modüle/pakete ihtiyacı varsa onu `require`'a yazar — composer
varlığı, sürümü ve yükleme sırasını çözer. `module.json` `requires` ise yalnızca
**yumuşak bir kapı** ve UI gösterimidir.
:::

## 3. `module.json` — manifest

Kurulum/kaldırmayı süren bildirimsel manifest. Alanlar `ModuleManifest` ile
tipli karşılığa çözülür.

```jsonc
{
  "key": "todo",
  "name": "Todo",
  "description": "Basit görev yönetimi.",
  "version": "1.0.0",
  "provider": "Herkobi\\Todo\\TodoServiceProvider",
  "areas": ["panel"],

  "requires": { "php": "^8.4", "laravel": "^13.0", "herkobi": "^1.0" },

  "publish": [
    { "from": "resources/js/pages/panel", "to": "resources/js/pages/panel/todo" }
  ],

  "migrate": true,
  "permissions": "remove",
  "purge_data": false,
  "enabled": true
}
```

- `publish` — `from` (paket köküne göreli) → `to` (proje köküne göreli). Yol
  güvenliği komutta zorlanır: `../` ile kök dışına çıkış reddedilir.
- `migrate: true` — `herkobi:install` migration'ları çalıştırır.
- `permissions: "remove"` — `herkobi:uninstall` modülün yetkilerini (onayla) siler.
- `purge_data: false` — uninstall **veriye dokunmaz**; yalnızca `--purge-data` ile.

## 4. Service Provider — katkıların kalbi

Tüm hook bağlamaları provider'ın **`register()`** metodunda yapılır; böylece
çekirdek tetiklemeden (rota yüklemesi) önce hazırdırlar. `HookManager` çekirdeğin
`ModuleServiceProvider`'ı tarafından singleton bağlandığı ve uygulama
provider'ları paket provider'larından **önce** register edildiği için, modül
`register()` içinde `hooks()` ile aynı singleton'a güvenle yazabilir.

```php
<?php

declare(strict_types=1);

namespace Herkobi\Todo;

use App\Support\Registry\MenuRegistry;
use App\Support\Registry\PermissionRegistry;
use Herkobi\Todo\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

final class TodoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // (a) Rotalar — panel middleware grubunun İÇİNDE tetiklenir.
        hooks()->action('panel.routes.register', function (): void {
            Route::get('/todos', [TodoController::class, 'index'])->name('todos.index');
            Route::post('/todos', [TodoController::class, 'store'])->name('todos.store');
        });

        // (b) Menü — kullanıcı bazında, yetki-filtreli kurulur.
        hooks()->action('panel.menu.register', function (MenuRegistry $menu): void {
            $menu->add('panel', 'platform', [
                'key' => 'panel.todos',
                'title' => 'Görevler',
                'href' => route('panel.todos.index'),
                'icon' => 'bookMarked',            // host'taki navigation-icons.ts anahtarı
                'permission' => 'panel.todos.index',
                'order' => 50,
            ]);
        });

        // (c) Yetkiler — source = modül anahtarı.
        hooks()->action('panel.permissions.register', function (PermissionRegistry $permissions): void {
            $permissions->addMany('panel', [
                ['name' => 'panel.todos.index', 'group' => 'Görevler', 'label' => 'Görevleri görüntüle'],
                ['name' => 'panel.todos.store', 'group' => 'Görevler', 'label' => 'Görev ekle'],
            ], source: 'todo');
        });
    }

    public function boot(): void
    {
        // Migration'lar pakette kalır, modülle versiyonlanır.
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}
```

::: warning Ad ve URL otomatik gelir
`routes/panel.php`, çekirdek tarafından `->prefix('panel')->name('panel.')` ile
yüklenir ve `hooks()->do('panel.routes.register')` **o grubun içinde** tetiklenir.
Dolayısıyla yukarıdaki `->name('todos.index')` rotası **`panel.todos.index`**
adını ve **`/panel/todos`** URL'sini alır; `auth, verified, user_type:admin,
active_user, write_access, route_permission` yığınını da otomatik miras alır.
:::

## 5. Yetkilendirme — bedavaya gelen koruma

Rota adı = yetki adı konvansiyonu gereği `panel.todos.index`, eşleşen yetki
verilene kadar **yalnızca Super Admin**'e açıktır. Yetkiler iki yoldan görünür:

- **Keşfet (her zaman):** `composer require` eder etmez `PermissionRegistry`'deki
  `panel.todos.*` kayıtları **Yetkiler → Rotalardan Keşfet** ekranında aday
  listesine düşer. Admin oradan içeri alır.
- **Install seed:** `herkobi:install todo`, `forSource('todo')` ile bu yetkileri
  DB'ye **seed eder** (idempotent) — ama **hiçbir role atamaz**. Rol dağıtımı
  admin kararıdır (Roller ekranı).

## 6. Controller ve ekran

```php
<?php

declare(strict_types=1);

namespace Herkobi\Todo\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

final class TodoController extends Controller
{
    public function index(): Response
    {
        // Publish edilen sayfa host'un pages/** tarama yoluna düştüğü için
        // ekstra yapılandırma olmadan çözülür.
        return Inertia::render('panel/todo/index', [
            'todos' => [], // gerçek veriyi burada geçir
        ]);
    }
}
```

Ekran (`packages/todo/resources/js/pages/panel/index.tsx`) çekirdeğin bileşenlerini
**`@` alias** ile import eder; tasarım sistemi tutarlılığı bedavaya gelir:

```tsx
import PanelLayout from '@/layouts/panel-layout'
import { Button } from '@/components/ui/button'

export default function TodoIndex() {
  return (
    <PanelLayout breadcrumbs={[{ title: 'Görevler', href: '/panel/todos' }]}>
      <div className="p-4">
        <h1 className="text-xl font-semibold">Görevler</h1>
        <Button className="mt-4">Yeni görev</Button>
      </div>
    </PanelLayout>
  )
}
```

::: tip Yeni ikon gerekiyorsa
`icon` değeri host'taki `resources/js/lib/navigation-icons.ts` haritasındaki bir
anahtar olmalıdır. Var olan bir anahtarı kullan (ör. `bookMarked`) ya da modülün
kendi ikonu için bu haritaya küçük bir giriş ekle (`listTodo: ListTodo`). Anahtar
bulunamazsa menü öğesi ikonsuz, ama sorunsuz çalışır.
:::

## 7. Migration

```php
<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('todos', function (Blueprint $table): void {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->boolean('done')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};
```

## 8. Opsiyonel: PHP `Installer`

`module.json`'ın ifade edemediği mantık (veri taşıma, dış servis temizliği) için.
Komut, sınıf varsa otomatik çağırır (`{Namespace}\{Studly(key)}Installer`).

```php
<?php

declare(strict_types=1);

namespace Herkobi\Todo;

final class TodoInstaller
{
    public function installed(): void { /* özel kurulum */ }

    public function uninstalling(): void { /* özel temizlik */ }
}
```

## 9. Yaşam döngüsü

```bash
composer require herkobi/todo      # backend ANINDA çalışır (rota/menü/yetki katkıları)
php artisan herkobi:install todo   # publish (ekran) + migrate (todos) + yetki seed
npm run build                      # publish edilen index.tsx derlenir
```

Kurulumdan sonra:
1. Sidebar'da *Platform → Görevler* görünür (Super Admin'de hemen; diğerlerinde
   yetki verilince).
2. `/panel/todos` ekranı açılır.
3. **Yetkiler** ekranında `panel.todos.*` yetkileri listelenir; **Roller**'den
   `Admin`'e atanabilir.

Kaldırma (sıra önemli — `composer remove`'dan **önce**):

```bash
php artisan herkobi:uninstall todo   # değiştirilmemiş publish dosyalarını siler,
                                      # permissions=remove → yetkileri (onayla) siler,
                                      # veriye dokunmaz (--purge-data ile rollback)
composer remove herkobi/todo
```

## 10. Net ayrım — kim neyi sağlar?

| Çekirdek (host) | Modül (`herkobi/todo`) |
|---|---|
| `panel.routes.register` / `panel.menu.register` / `panel.permissions.register` hook'larını **tetikler** | Bu hook'lara **bağlanır** (provider `register()`) |
| `MenuRegistry` / `PermissionRegistry` tipli API'lerini **sunar** | Bu API'lere menü/yetki **yazar** |
| Middleware yığınını, `panel.` ad önekini, `route_permission` korumasını **uygular** | Yalnızca `Route::get('/todos')` der; yığını/prefix'i **hardcode etmez** |
| `@/components/ui/*`, layout, hook'ları **sağlar** | Bunları `@` alias ile **import eder** |
| `herkobi:install` / `herkobi:uninstall` komutlarını **çalıştırır** | `module.json` ile *ne* yapılacağını **bildirir** |

> Sonuç: modül, çekirdeğin tek bir satırını değiştirmeden tam teşekküllü bir panel
> özelliği ekler. Çekirdek hangi modüllerin var olduğunu bilmek zorunda değildir;
> yalnızca genişleme noktalarını tetikler.
