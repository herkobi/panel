# Başlarken

Herkobi® Panel; **Laravel 13 + PHP 8.4**, **React 19 + TypeScript + Inertia v3**,
**Tailwind v4 + shadcn/ui** ve **Vite** üzerine kuruludur. Tek bir kod tabanı iki
alanı birden besler: yönetim paneli (`/panel`) ve üye uygulaması (`/app`).

## Gereksinimler

- PHP **8.4+** ve Composer
- Node.js **20+** ve npm
- **MySQL** (8.0+) veya **MariaDB** (10.6+)

## Kurulum

```bash
git clone https://github.com/herkobi/panel.git
cd panel

composer setup     # bağımlılıklar, .env, app key, migrate, varlıkları derler
composer dev       # sunucu + kuyruk dinleyici + Vite (hepsi birlikte)
```

`composer setup` ilk kurulumu tek komutta yapar: bağımlılıkları kurar, `.env`
dosyasını oluşturur, uygulama anahtarını üretir, migration'ları çalıştırır,
npm bağımlılıklarını kurar ve üretim varlıklarını derler.

## İlk giriş

Tohumlanan (seed) varsayılan yönetici:

| Alan | Değer |
|---|---|
| E-posta | `admin@admin.com` |
| Parola | `password` |

Giriş sonrası `/dashboard`, kullanıcının türüne göre **`/panel`** (yönetici) veya
**`/app`** (üye) ekranına yönlendirir. Tedarikçi veya pasif kullanıcılar oturumdan
çıkarılır.

## Geliştirme komutları

```bash
composer dev            # serve + queue + vite (geliştirme)
composer test           # config temizle + Pint kontrol + Pest
composer ci:check       # tam CI: lint + format + types + test

npm run lint            # ESLint --fix          npm run lint:check
npm run format          # Prettier write        npm run format:check
npm run types:check     # tsc --noEmit          npm run build

php artisan test --filter=Ad
php artisan wayfinder:generate --with-form --no-interaction   # rota değişince
```

::: tip Rota değiştiyse
Her rota ekleme/değişikliğinden sonra tipli rotaları yeniden üret:
`php artisan wayfinder:generate --with-form --no-interaction`. Tipli rota
yardımcıları `resources/js/{routes,actions}` altına yazılır.
:::

## Sonraki adımlar

- [Mimari](/genel/mimari) — çift alan, hesap kapsamı, olay-tabanlı yan etkiler.
- [Kod Yapısı](/genel/kod-yapisi) — dizin düzeni ve konvansiyonlar.
- [Panel rehberi](/panel/dashboard) — yönetim ekranları.
- [Modül Sistemi](/sistemler/moduller) — çekirdeği düzenlemeden genişletme.
