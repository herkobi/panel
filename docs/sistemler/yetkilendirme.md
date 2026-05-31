# Yetkilendirme

Herkobi® Panel, `spatie/laravel-permission` üzerine kurulu **arayüz-odaklı** bir
yetkilendirme kullanır: yetki config dosyası yoktur, artisan sync yoktur. Üç parça
birlikte çalışır.

## 1) Super Admin için `Gate::before`

`AppServiceProvider` içinde tanımlıdır: **`Super Admin`** rolüne sahip her
kullanıcı, tüm `can()` kontrollerini geçer. Super Admin'e bireysel yetki
**atanmaz** ve **rol seçimlerinde hiç sunulmaz** (yalnızca seeder/konsoldan
atanır).

## 2) `EnsureRoutePermission` middleware'i

Alias `route_permission`, yalnızca **panel** grubunda çalışır. Konvansiyon:

::: tip Rota adı = yetki adı
Her isimli panel rotası, otomatik olarak `$user->can($routeName)` ile korunur.
Yani `panel.members.index` rotasına erişim, aynı isimli yetkiyi gerektirir.
:::

Sonuç: eklediğiniz **yeni bir panel rotası**, adıyla eşleşen yetki küratörlükten
geçene kadar **yalnızca Super Admin**'e açıktır. Bu, "yetkiyi vermeyi unuttum →
herkes erişti" hatasını yapısal olarak engeller.

**Muafiyetler:** `panel.dashboard` ve tüm `panel.profile.*` rotaları (kişisel
alanlar — profil/güvenlik/oturumlar/bildirimler). Bunlar yetki-gated değildir ve
yetki keşfinden hariç tutulur.

## 3) Yetkiler ekranı (küratörlük)

`panel/settings/permissions` ekranı yetkileri yönetir:

- Listeleme, düzenleme, silme, elle yeni yetki ekleme.
- **"Rotalardan Keşfet"** — panel rota adlarını toplu olarak yetkiye dönüştürür;
  `group` ve `label`'ı rota adından otomatik türetir.

`permissions` tablosu iki UI-metadata sütunu taşır: `group` ve `label` (nullable;
null → "Diğer" + yetki adı).

![Rotalardan Keşfet](/images/settings-permissions-discover.png)

## Roller ve tohumlama

`RolePermissionSeeder` yalnızca iki sistem rolünü tohumlar: **`Super Admin`** ve
**`Admin`**. Admin boş başlar ve arayüzden küratörlükle doldurulur. Sistem
rolleri silinemez/yeniden adlandırılamaz (`RoleService::SYSTEM_ROLES`).

::: warning Policy yok (şimdilik)
Bu uygulama, rota-seviyesi `route_permission` konvansiyonuyla yetkilendirir;
Spatie'nin `role` / `permission` route-middleware alias'ları kayıtlı ama
**kullanılmaz**. Policy'ye yalnızca rota-seviyesi kontroller yetmediğinde
başvurulur (bugün hiç yok).
:::

## React tarafında yetki kontrolü

UI'da koşullu gösterim için hazır hook'lar bulunur (ready-but-ready scaffolding):
`useCan`, `useHasRole`, `useIsSuperAdmin` ([use-permissions.ts]). Menü zaten
`MenuRegistry` tarafından `permission` alanına göre süzülür.
