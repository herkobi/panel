# Herkobi Panel

> Laravel ile backend sistem geliştirmek isteyenler için, **kullanıcı ve etkinlik yönetimini hazır sunan** başlangıç altyapısı.

Herkobi Panel; kimlik doğrulama, üye/kullanıcı yönetimi, rol-yetki, ayarlar, etkinlik kaydı ve admin/üye ayrımı gibi her projede tekrar tekrar yazılan parçaları **tek bir tutarlı iskelet** hâlinde sunar. İndir, kendi iş mantığını üstüne yaz, kullan.

**MIT lisanslı, ücretsiz.**

---

## Neler hazır geliyor?

- **Kimlik doğrulama (Fortify)** — Giriş, kayıt, e-posta doğrulama, parola sıfırlama, parola onayı, **2FA / TOTP** (QR + kurtarma kodları).
- **Çift alan mimarisi**
  - `/panel` → Admin kullanıcılar (`user_type:admin`)
  - `/app` → Üye kullanıcılar (`user_type:member`)
- **Üye yönetimi** — Admin panelinden üye oluşturma, durum değiştirme, e-posta doğrulama / değiştirme, üye detayları.
- **Rol ve yetki** — Spatie Permission ile rol CRUD ve granular yetki kontrolü; tüm panel/app rotalarında `permission:...` middleware desteği.
- **Profil paketi (her iki alan için)**
  - Profil bilgileri ve e-posta güncelleme (throttle korumalı)
  - Güvenlik (parola değişikliği, 2FA)
  - Aktif oturumlar (görüntüleme + uzaktan sonlandırma)
  - Bildirimler (okunma durumu)
  - Görünüm tercihi (light/dark/system)
- **Hesap (App alanı)** — Üyenin firma/iletişim bilgileri yönetimi.
- **Etkinlik kaydı** — `spatie/laravel-activitylog` ile model değişiklikleri ve önemli aksiyonlar; panelden listelenebilir.
- **Giriş kaydı** — `yadahan/laravel-authentication-log` ile her oturumun cihaz/IP/konum izi; yeni cihaz bildirimi hazır listener'la.
- **Tanımlamalar (definitions)** — Ülke, şehir, ilçe, dil, para birimi, vergi için CRUD + soft-delete + geri yükleme.
- **Önbellek araçları** — Panel üzerinden tip bazlı cache temizleme.
- **Çoklu dil** — Türkçe (`tr`, varsayılan) ve İngilizce (`en`) eş güncel tutulur.
- **Karanlık mod** — `next-themes` üzerinden.
- **Olay odaklı (event-driven)** — Yan etkiler (log, bildirim, e-posta, kuyruk işi) controller/servisten **değil**, `event → listener` zincirinden akar. Hâlihazırda 23 event, 24 listener tanımlı.
- **Modern frontend** — React 19 + TypeScript + Inertia.js v3 + Tailwind v4 + shadcn/ui; **Wayfinder** ile uçtan uca tip güvenli rota fonksiyonları.

---

## Teknoloji yığını

**Backend**

- Laravel 13.7 (PHP 8.3+)
- Laravel Fortify · Wayfinder · Tinker
- Spatie Laravel Permission · Spatie Activity Log
- Yadahan Authentication Log
- Pest 4 + Pest Browser

**Frontend**

- React 19 + TypeScript (strict)
- Inertia.js v3
- Tailwind CSS v4 (config dosyası yok, `resources/css/app.css` girişi)
- shadcn/ui + Base UI primitives
- Lucide React (ikonlar)
- Vite 8 + babel-plugin-react-compiler

**Veritabanı / Çalışma zamanı**

- Varsayılan: **MySQL** (SQLite / MariaDB / PostgreSQL / SQL Server'a geçilebilir)
- **UUID** birincil anahtarlar (`HasUuids` tüm modellerde)
- `User` modelinde **soft delete**
- Queue · Cache · Session · sürücüsü: `database`

---

## Sistem gereksinimleri

- PHP **8.3+**
- Composer 2.x
- Node.js **20+** ve npm
- Bir veritabanı — varsayılan **MySQL** (yerelde MySQL servisi çalışıyor olmalı; `.env`'de `DB_*` değerleri ayarlanır). SQLite'a geçilecekse `DB_CONNECTION=sqlite` yeterli.

---

## Kurulum

```bash
git clone <repo-url> herkobi-panel
cd herkobi-panel

# Bağımlılıklar + .env + key + migrate + npm install + build
composer setup
```

`composer setup` yapılan işler:

1. `composer install`
2. `.env` yoksa `.env.example`'dan kopyalanır
3. `php artisan key:generate`
4. `php artisan migrate --force`
5. `npm install`
6. `npm run build`

Ardından geliştirme sunucusunu başlatın:

```bash
composer dev
```

Bu komut `php artisan serve`, `php artisan queue:listen` ve `npm run dev`'i **concurrently** ile aynı anda çalıştırır.

---

## Sık kullanılan komutlar

```bash
# Geliştirme (Laravel + queue + Vite)
composer dev

# Tek seferlik build
npm run build

# Rota değişikliğinden sonra mutlaka çalıştırın
php artisan wayfinder:generate --with-form --no-interaction

# Kod kalitesi
composer lint           # Pint formatla
composer lint:check     # Pint sadece kontrol
npm run lint            # ESLint --fix
npm run lint:check
npm run format          # Prettier --write
npm run types:check     # tsc --noEmit

# Test
composer test                              # config:clear + lint + pest
php artisan test --filter=TestName         # tek test

# Tam CI parite kontrolü (push öncesi)
composer ci:check
```

---

## Mimari notlar

### Bağımlılık yönü

Üst katman alttakine bağımlı olabilir; tersi **yasak**:

```
Enum → Migration → Model → Service → Event → Listener →
Notification → Job → Request → Controller → Resource →
Page/UI → Middleware → Seeder → Permission
```

### Olay odaklı yan etki kuralı

Controller ince kalır, servisler iş kuralını taşır. Her yan etki — aktivite kaydı, bildirim, e-posta, kuyruk işi — **`event() → listener` zinciri** üzerinden akar; controller veya servisten doğrudan tetiklenmez.

### Inertia paylaşımlı `auth` sözleşmesi

Tek bir paylaşımlı prop vardır: `auth`, ve `auth.type: 'app' | 'panel'` ile ayrılır.

- App alanı React kodunda → `useAppAuth()`
- Panel alanı React kodunda → `usePanelAuth()`

`usePage().props.auth`'u doğrudan okumayın; `AppUser` ve `PanelUser` tiplerini karıştırmayın.

### Özel middleware

| Middleware | Görev |
|---|---|
| `active_user` | Pasif kullanıcının erişimini engeller |
| `user_type:admin\|member` | Alan ayrımını uygular |
| `write_access` | Yazma yetkisi olmayan kullanıcıları yalnızca okumaya kısıtlar |
| `HandleInertiaRequests` | Paylaşımlı `auth` prop'unu üretir |
| `SetSecurityHeaders` | Güvenlik başlıkları |

### Modeller

- Tüm modeller `HasUuids` kullanır — birincil ve yabancı anahtarlar **UUID string**.
- `User` modeli `SoftDeletes` — adminler hard-delete edemez.
- PHP 8.3 attribute'ları: `#[Fillable([...])]`, `#[Hidden([...])]`, `#[Scope]`.
- Her PHP dosyası `declare(strict_types=1);` ile başlar.

---

## Klasör yapısı

```
app/
  Actions/Fortify/      Fortify aksiyonları
  Enums/                Status, UserStatus, UserType
  Events/{Panel,App,Auth}
  Http/Controllers/{Panel,App}
  Http/Middleware/      Özel middleware
  Listeners/{Panel,App,Auth}
  Models/               UUID + HasUuids
  Notifications/{Panel,App,Auth}
  Services/{Panel,App,Support}
resources/
  css/app.css           Tailwind v4 girişi
  js/
    actions/            Wayfinder action fonksiyonları (üretilen)
    routes/             Wayfinder route helper'ları (üretilen)
    components/ui/      shadcn/ui (elle düzenlenmez)
    components/{app,panel}/
    hooks/              useAppAuth, usePanelAuth, vb.
    layouts/{app,panel,auth}/
    pages/{app,panel,auth}/
    types/
routes/
  panel.php             /panel — admin
  app.php               /app — üye
  web.php               public + dashboard yönlendirme
lang/{tr,en}/           Çeviriler (eş güncel tutulur)
```

---

## Test

Testler — uygulama varsayılanından bağımsız olarak — **SQLite `:memory:`** üzerinde, `sync` queue ve `array` cache/session ile koşar (bkz. [phpunit.xml](phpunit.xml)). DB'ye dokunan feature testlerinde `RefreshDatabase` kullanın.

```bash
composer test           # Pint + Pest
composer ci:check       # lint + format + types + test (CI'la birebir)
```

---

## Bilinmesi gerekenler

- Her rota değişikliğinden sonra `php artisan wayfinder:generate` çalıştırın; frontend hardcoded URL kullanmaz.
- Yetkilendirme bugün **middleware tabanlı**dır; ihtiyaç çıkarsa Policy eklenir.
- Yeni e-posta işleri için: kuyruğa alınan bir **Job**, içinden bir **Mailable** dispatch eder. Görünümler `resources/views/mail/` altına gelir.
- shadcn/ui primitive'leri üretilmiştir ve ESLint/Prettier dışındadır — elle düzenlemeyin, regenerate edin.

---

## Katkı

PR'lara açıktır. Göndermeden önce lütfen şunu çalıştırın:

```bash
composer ci:check
```

Yeşil değilse merge edilmez. Türkçe ve İngilizce çeviri dosyalarını eş güncel tutun.

---

## Lisans

[MIT](LICENSE) © Herkobi

Bu proje **özgürce** indirilebilir, değiştirilebilir, ticari ve kişisel projelerde kullanılabilir. Tek koşul lisans dosyasının dağıtımda korunmasıdır.
