# Panel — Ayarlar

*Ayarlar* grubu **Genel Ayarlar** ve **Kullanıcılar** (Kullanıcılar, Roller,
Yetkiler) ekranlarını içerir.

## Genel Ayarlar

![Genel Ayarlar](/images/settings-general.png)

Uygulama kimliğini ve varsayılanları buradan yönetirsiniz. Ayarlar `Setting`
modelinde (`Setting::allCached()` ile önbelleklenir) `general` / `branding` /
`defaults` gruplarında tutulur ve `SettingsService` üzerinden yönetilir.

- **Markalama:** uygulama adı, sloganı, logo (açık/koyu) ve favicon. Görseller
  `ImageUpload` bileşeniyle yüklenir; hiçbir şey yüklenmezse `fallbackUrl`
  varsayılan markayı önizler. Ayrıntı: [Markalama](/sistemler/markalama).
- **Varsayılanlar:** varsayılan ülke / para birimi / vergi / dil / saat dilimi
  seçimleri (bunlar `DefinitionGuard` ile korunur).

Rota/yetki: `panel.settings.general.edit`.

## Kullanıcılar (Yöneticiler)

![Kullanıcılar listesi](/images/settings-users.png)

Yönetici (`user_type:admin`) kullanıcıları. Liste, ekleme ve detay ekranları
vardır. Yöneticilerde `account_id = null`'dır (hesaplar arası).

Rota/yetki: `panel.settings.users.index`, `panel.settings.users.create`.

## Roller

![Roller](/images/settings-roles.png)

Spatie laravel-permission rolleri. Sistem rolleri **`Super Admin`** ve
**`Admin`**'dir (`RoleService::SYSTEM_ROLES`):

- **Super Admin** — `Gate::before` ile her `can()` kontrolünü geçer; bireysel
  yetki atanmaz ve **rol seçimlerinde hiç sunulmaz** (yalnızca seeder/konsoldan
  atanır).
- **Admin** — boş başlar; yetkileri arayüzden küratörlükle doldurulur.

Sistem rolleri silinemez/yeniden adlandırılamaz. Rol detayında o role ait
yetkiler atanır.

Rota/yetki: `panel.settings.roles.index`.

## Yetkiler

![Yetkiler](/images/settings-permissions.png)

Yetki yönetimi tamamen **arayüz-odaklıdır** (config dosyası veya artisan sync
yoktur). Yetkileri listeleyebilir, düzenleyebilir, silebilir, elle yenisini
ekleyebilir veya **"Rotalardan Keşfet"** ile panel rota adlarını toplu olarak
yetkiye dönüştürebilirsiniz.

![Rotalardan Keşfet](/images/settings-permissions-discover.png)

`permissions` tablosu iki UI-metadata sütunu taşır: `group` ve `label`
(nullable; null → "Diğer" + yetki adı). Keşfet, rota adından `group`/`label`'ı
otomatik türetir.

::: warning Rota adı = yetki adı
Her isimli panel rotası `route_permission` ile otomatik korunur. Yeni bir rota,
adıyla eşleşen yetki küratörlükten geçene kadar **yalnızca Super Admin**'e
açıktır. Kişisel `panel.profile.*` rotaları muaftır. Tüm mantık:
[Yetkilendirme](/sistemler/yetkilendirme).
:::

Rota/yetki: `panel.settings.permissions.index`.
