# Modül Sistemi

Herkobi® Panel bir başlangıç kiti olduğundan, composer paketlerinin çekirdeği
düzenlemeden panele/app'e **menü, rota, yetki, ekran ve mail** eklemesini sağlayan
bir **modül sistemi** ile gelir. Mekanizma **Hook + Registry**'dir ve Laravel'in
kendi primitifleri (paket auto-discovery, provider yaşam döngüsü, tipli
registry'ler) üzerine kuruludur.

> **Temel ilke:** `module.json` *ne* yapılacağını **bildirir** (data); artisan
> komutları *nasıl* ve **güvenliği** uygular; gerçek mantık gerektiğinde tipli
> PHP'de kalır (string/JSON içinde değil).

::: tip Hemen kod görmek istersen
Bu sayfa mekanizmayı anlatır. Baştan sona çalışan bir örnek için:
[Örnek: `todo` Modülü](/sistemler/ornek-todo-modulu) — composer paketi,
`module.json`, provider, rota + menü + yetki katkısı ve yaşam döngüsü.
:::

## Hook + Registry

- **Hook'lar** (`app/Support/Hooks/HookManager.php`, global `hooks()` helper'ı) —
  çekirdek isimli genişleme noktaları tetikler; modüller callback bağlar.
  `hooks()->do('panel.routes.register')` **panel middleware grubunun içinde**
  tetiklenir; böylece modül rotaları tam yığını (`route_permission` vb.) ve
  `panel.` ad ön ekini otomatik miras alır. API: yan etki için `action`/`do`,
  değer dönüştürme için `filter`/`apply`. Callback'ler provider'ın **`register()`**
  metodunda kaydedilmelidir (çekirdek tetiklemeden önce).
- **Registry'ler** (`MenuRegistry`, `PermissionRegistry`) — hook callback'inin
  içinde modülün yazdığı **tipli** builder'lar. Çekirdeğin kendi menüsü de aynı
  yolla kaydedilir (`ModuleServiceProvider`). Menü yetki-farkındadır, `order`-sıralı
  ve her istek için kurulur; `navigation` prop'u olarak paylaşılır.

> Kısaca: **hook = "ne zaman / nerede katkı ver", registry = "neyi tipli olarak
> ekle".**

## Modül = composer paketi

Bir modül, Laravel **auto-discovery** ile yüklenen sıradan bir composer
paketidir. **PHP'de derleme yoktur** — paket require edilir edilmez rota,
controller ve registry katkıları çalışır. **Derleme yalnızca ön yüz içindir**
(Vite), publish sonrası.

```bash
composer require herkobi/todo      # backend ANINDA çalışır (auto-discovery)
php artisan herkobi:install todo   # module.json: publish + migrate + yetki seed
npm run build                      # publish edilen ön yüzü derle (veya npm run dev)

php artisan herkobi:uninstall todo # geri al — composer remove'DAN ÖNCE; --purge-data tabloları düşürür
composer remove herkobi/todo
```

::: warning Sıra önemli
`herkobi:uninstall`, **`composer remove`'dan önce** çalışmalıdır; neyi geri
alacağını `module.json`'dan okur. Paket önce silinirse manifest kaybolur.
:::

Yerel geliştirme için kök `composer.json`'a bir path repository (`packages/*`)
ekleyerek publish'siz çalışılabilir.

## `module.json` manifesti

Modülün kökünde durur: kimlik + bağımlılık kapısı + publish haritası + lifecycle
bayrakları.

```jsonc
{
  "key": "todo",
  "name": "Todo",
  "provider": "Herkobi\\Todo\\TodoServiceProvider",
  "areas": ["panel", "app"],
  "requires": { "php": "^8.4", "laravel": "^13.0", "herkobi": "^1.0" }, // yumuşak kapı; gerçek bağımlılık composer.json'da
  "publish": [                                                          // from (paket) → to (proje)
    { "from": "resources/js/pages/panel", "to": "resources/js/pages/panel/todo" },
    { "from": "resources/views/mail",     "to": "resources/views/vendor/todo" }
  ],
  "migrate": true,            // install migration'ları çalıştırır
  "permissions": "remove",    // uninstall davranışı: "remove" | "keep"
  "purge_data": false,        // uninstall varsayılanı: --purge-data olmadan veriyi koru
  "enabled": true
}
```

`publish` haritası uninstall'da **tersine** alınır (DRY); farklı davranış gereken
modül ayrı `install` / `uninstall` blokları tanımlayabilir.

## Rota, menü, yetki

- **Rotalar** — çekirdek `hooks()->do('{area}.routes.register')`'ı middleware
  grubunun *içinde* tetikler; modül rotalarını orada kaydeder ve yığını + ad ön
  ekini miras alır. `route_permission` konvansiyonu gereği modülün panel
  rotaları, eşleşen yetki küratörlükten geçene kadar Super-Admin-only'dir.
- **Yetkiler** — modüller `PermissionRegistry`'ye yetkilerini bir `source`
  (modül anahtarı) ile yazar. Bunlar `composer require` ile **"Rotalardan Keşfet"**
  ekranında görünür (install gerekmez); `herkobi:install` ise bunları
  `forSource('todo')` ile seed eder, **role atamadan** (rol dağıtımı admin
  kararıdır).
- **Menü** — çekirdekle aynı `MenuRegistry`. `navigation` prop'u mevcut
  `auth` / `branding` / `flash` sözleşmesine **ek** verilir; bunlar değiştirilmez.

## Kurulum / kaldırma güvenliği

- **install** `requires`'ı doğrular, **çakışma denetimi** yapar (rota/yetki adı
  çakışırsa uyarır), `publish` haritasını kopyalar (`--force` ile üzerine yazar),
  `migrate: true` ise migrate eder, yetkileri seed eder, sonra `npm run build`
  hatırlatır.
- **uninstall** **güvenli varsayılandır**: yalnızca **değiştirilmemiş** (kaynakla
  birebir) publish hedeflerini siler; düzenlenmiş olanları silmez, raporlar.
  Tablolara/veriye **dokunmaz** (yalnızca `--purge-data` ile rollback + modülün
  settings satırları). Yetkiler `module.json`'daki `"permissions"` bayrağına göre
  (`remove` → onay + etkilenen rol raporu, sonra sil; `keep` → bırak).
  **Yol güvenliği:** `from` (paket kökü içinde) ve `to` (proje kökü içinde)
  doğrulanır — `../` kaçışları reddedilir.
- **PHP `Installer` kaçış kapısı** — `module.json`'ın ifade edemediği mantık
  (veri taşıma, dış temizlik) için modül opsiyonel bir sınıf (`installed()` /
  `uninstalling()`) sağlayabilir; komut varsa çağırır.

## Ön yüz tutarlılığı

Modüller kendi tasarım sistemini taşımaz: çekirdeğin bileşenlerini **`@` alias**
ile import eder (`@/components/ui/*`, layout'lar, hook'lar) ve sayfaları `.tsx`
olarak gönderir; host'un Vite/TS/alias'ıyla derlenir. Publish edilen sayfalar
host'un `pages/**` tarama yoluna düştüğü için `Inertia::render('panel/todo/index')`
ekstra yapılandırma olmadan çözülür.

## Hook referansı

Çekirdeğin tetiklediği genişleme noktaları. Modüller bunlara provider'larının
`register()` metodunda `hooks()->action(...)` ile bağlanır.

| Hook | Ne zaman tetiklenir | Callback argümanı | Amaç |
|---|---|---|---|
| `panel.routes.register` | `routes/panel.php` yüklenirken (grup içinde) | — | Panel rotaları ekle (`panel.` + `/panel` + tam middleware) |
| `app.routes.register` | `routes/app.php` yüklenirken (grup içinde) | — | App rotaları ekle (`app.` + `/app` + `bind_account`) |
| `panel.menu.register` | Panel menüsü kurulurken (istek başına) | `MenuRegistry $menu` | Sidebar grubu/öğesi ekle |
| `app.menu.register` | App menüsü kurulurken (istek başına) | `MenuRegistry $menu` | Sidebar grubu/öğesi ekle |
| `panel.permissions.register` | Yetki listesi derlenirken | `PermissionRegistry $permissions` | Panel yetkisi bildir (`source` ile) |
| `app.permissions.register` | Yetki listesi derlenirken | `PermissionRegistry $permissions` | App yetkisi bildir (`source` ile) |

### Hook API'si

`HookManager` iki tür hook sunar (öncelik küçükten büyüğe çalışır; callback'ler
container ile çözülür, bağımlılıkları type-hint'le alabilirsin):

```php
hooks()->action(string $hook, callable $cb, int $priority = 10): void; // dinle (yan etki)
hooks()->do(string $hook, mixed ...$args): void;                        // tetikle
hooks()->filter(string $hook, callable $cb, int $priority = 10): void;  // dinle (değer dönüştür)
hooks()->apply(string $hook, mixed $value, mixed ...$args): mixed;      // tetikle, dönüştürülmüş değeri al
```

- **action / do** — dönüş değeri yok; menü/rota/yetki kaydı gibi yan etkiler için.
- **filter / apply** — bir değeri zincirleme dönüştürür; ilk callback argümanı
  daima dönüştürülecek `$value`'dur.

::: tip Modüller arası sıra
Bir modül başka bir modülün registry katkısına bağlıysa, hook'a `register()`
yerine provider'ın `booted()` callback'inde bağlan — tüm provider'lar register
olduktan sonra çalışır, sıra sorunu kalmaz.
:::

## Bilinçli olarak ertelenenler

Admin **"Modüller"** ekranı (runtime aç/kapa) ve **kullanıcı sidebar sıralaması**
(sürükle-bırak) henüz yok; `module.json` ve order-farkında registry bunlara hazır
veri kaynağıdır.
