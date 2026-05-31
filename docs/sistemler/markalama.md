# Markalama

`App\Support\Branding`, uygulama kimliğinin **tek kaynağıdır**. Marka değerleri
`settings` tablosundan okunur, yoksa makul varsayılanlara düşülür.

| Yöntem | Kaynak | Varsayılan |
|---|---|---|
| `name()` / `slogan()` | `settings` | `config('app.name')` |
| `logo()` | yüklenen görsel | `public/herkobi.png` |
| `logoDark()` | yüklenen görsel | `public/herkobi-white.png` |
| `favicon()` | yüklenen görsel | `public/herkobi-ikon.png` |

`Branding::toArray()` her Inertia isteğinde `branding` prop'u olarak paylaşılır ve
React'te `useBranding()` ile okunur.

## Nerede kullanılır?

- Blade kök `<title>` ve favicon bağlantısı.
- Sidebar `BrandHeader` (favicon + uygulama adı).
- Auth (giriş) yerleşimi — logo, açık/koyu.
- Mail başlığı — logo.

::: tip Favicon nerede?
**Favicon yalnızca sidebar'da** kullanılır; diğer her yerde normal logo
kullanılır.
:::

## Özel değerleri yönetmek

Marka değerleri **Genel Ayarlar** (`panel/settings/general`) ekranından,
`ImageUpload` bileşeniyle yönetilir. Hiçbir görsel yüklenmemişse `ImageUpload`'ın
`fallbackUrl`'i markalama varsayılanını önizler.

![Genel Ayarlar — markalama](/images/settings-general.png)

::: warning Hardcode etme
Uygulama adı / logo / favicon asla şablona gömülmez — her zaman
`App\Support\Branding` üzerinden okunur.
:::
