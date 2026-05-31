# Kod Yapısı

Bu sayfa dizin düzenini ve günlük çalışırken uyulan konvansiyonları özetler.

## Dizin düzeni

```
app/
  Http/Controllers/{Panel,App}/   Requests, Resources aynı ayrımı izler
  Http/Middleware/                BindCurrentAccount, EnsureRoutePermission …
  Events/ Listeners/              event() → listener yan etkileri (otomatik keşif)
  Services/{Panel,App}/           iş kuralları (controller'lar ince kalır)
  Models/  Enums/  Concerns/      HasUuids, BelongsToAccount, HasStatus, HasMedia …
  Support/                        Branding, ActivitySubjectLabels
  Support/Hooks/ Registry/ Modules/   modül sistemi (HookManager, Menu/PermissionRegistry, manifest)
  Providers/                      AppServiceProvider, ModuleServiceProvider …
  Console/Commands/               herkobi:install · herkobi:uninstall
routes/
  panel.php  app.php  web.php     /panel (yönetim) · /app (üye)
packages/                         yerel modül paketleri (path repository, opsiyonel)
resources/
  js/pages/{panel,app}/           Inertia sayfaları
  js/components/  js/hooks/        paylaşılan UI + hook'lar (ui/* üretilir)
  js/layouts/{panel,app,auth}/     yerleşim şablonları
  js/types/                       merkezî TypeScript tipleri (barrel: @/types)
  js/routes/  js/actions/         Wayfinder ile üretilen tipli rotalar
  views/                          Blade kök + mail şablonları
lang/{tr,en}/                     Türkçe birincil, İngilizce paralel
```

## Backend konvansiyonları

- **Katılık:** her dosya `declare(strict_types=1);`. Modeller `HasUuids` ve PHP
  8.3 attribute'ları (`#[Fillable]`, `#[Hidden]`, `#[Scope]`). `CarbonImmutable`.
- **İnce controller, kalın servis:** iş kuralları `Services/{Panel,App}` altında.
- **Yan etki yalnızca olayla:** etkinlik kaydı / bildirim / mail
  `event() → listener` ile; controller/servisten doğrudan tetiklenmez.
- **Paylaşılan model concern'leri** (`app/Concerns/`):
  - `HasStatus` — `Active`/`Passive` scope'ları + `isActive()`.
  - `HasSortOrder` — `ordered()` scope + otomatik `sort_order`.
  - `BelongsToAccount` — Account ilişkisi + koşullu global scope + creating hook.
  - `HasMedia` — polimorfik `media()` ilişkisi + per-sahip depolama.
  - `LogsActivity` — `Log*`/`Send*` listener'larında etkinlik yazımını DRY tutar.

## Frontend konvansiyonları

- **TS strict**; alias `@/* → ./resources/js/*`. React Compiler açık.
- **shadcn/ui primitifleri** `resources/js/components/ui/` altında **üretilir** —
  elle düzenlenmez (ESLint/Prettier dışı). Tek bilinçli istisna: `button.tsx`
  içindeki global `cursor-pointer`.
- **Endpoint çağrıları:** Inertia `useForm` + Wayfinder rota/action fonksiyonları.
  URL'ler hardcode edilmez.
- **Tailwind v4** (config dosyası yok); giriş `resources/css/app.css`. Koyu tema
  `next-themes` ile.

### TypeScript tipleri

- **Paylaşılan / tekrar eden / backend'i yansıtan tipler → `resources/js/types/`**
  (barrel: `@/types`). Sayfa `Props` / `PageProps` ve tek seferlik küçük
  görünüm-modelleri sayfanın **içinde** kalır.
- `{ value, label }` şekilleri için `Option<TValue>` yeniden kullanılır.
- Alan tipleri kendi alanında: `definitions.ts`, `permission.ts`, `role.ts`,
  `session.ts`, `user-status.ts` …

### Paylaşılan bileşenler & hook'lar

- **DataPagination** — herhangi bir Laravel paginator'ını render eder
  (`PaginatedResource::make(...)` ile eşlenir).
- **ConfirmDelete** — AlertDialog tabanlı silme onayı; her yıkıcı işlem önce onaylar.
- **Hook'lar:** `useAppAuth` / `usePanelAuth`, `useBranding`, `usePermissions`,
  `useActiveNavHref`, `useFlashToast`, `useCurrentUrl`.

## Bilinçli "hazır ama bağlanmamış" scaffolding

Herkobi® Panel bir başlangıç kiti olduğundan, tamamlanmış ama henüz hiçbir yerde
kullanılmayan parçalar **bilerek** bulunur — ihtiyaç anında hemen kullanılsınlar
diye. **Bunlar ölü kod değildir; temizlik sırasında silinmez.**

- shadcn/ui setinin **tamamı** kurulu; bugün yalnızca bir kısmı bağlı.
- `useCan` / `useHasRole` / `useIsSuperAdmin` izin hook'ları.
- `*_LABEL` / `*_OPTIONS` / `*_VALUES` enum yardımcıları (`status`, `user-status`,
  `user-type`).
- Alternatif yerleşimler (`auth-card`, `auth-split`, `app/panel header layout`).
- `media-gallery` bileşeni.

## Kalite çıtası

```bash
composer ci:check   # ESLint + Prettier + tsc + Pest — PR öncesi yeşil olmalı
```

- Rota değiştiyse Wayfinder yeniden üretilir; `tr`/`en` metinleri senkron tutulur.
- Davranış değişiklikleri Pest testleriyle kapsanır (feature testleri
  `RefreshDatabase`).
- `components/ui/*` elle düzenlenmez; URL/markalama hardcode edilmez.
