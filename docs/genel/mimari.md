# Mimari

Herkobi® Panel'in tamamı birkaç temel karar üzerine kurulur. Bu sayfa o kararları ve
neden öyle olduklarını anlatır.

## Çift alan: Panel (yönetim) vs App (üye)

Kod, `Panel/*` (yönetim) ve `App/*` (üye) olarak **aynalanır**:

- **`routes/panel.php`** — `/panel` ön eki, middleware:
  `auth, verified, user_type:admin, active_user, write_access, route_permission`.
- **`routes/app.php`** — `/app` ön eki, middleware:
  `auth, verified, user_type:member, active_user, write_access, bind_account`.
- **`/dashboard`** kullanıcı türüne göre yönlendirir; tedarikçi / pasif
  kullanıcılar oturumdan çıkarılır.

Aynı ayrım her katmanda görülür:

```
app/Http/Controllers/{Panel,App}/   Requests/{Panel,App}/   Resources/{Panel,App}/
app/Events/{Panel,App,Auth}/        Listeners/{Panel,App,Auth}/
app/Services/{Panel,App}/           resources/js/pages/{panel,app}/
layouts: panel/   vs   app/
```

## Paylaşılan Inertia prop'ları

`HandleInertiaRequests::share()` her istekte tam olarak şu prop'ları paylaşır:

| Prop | Açıklama |
|---|---|
| `auth` | Tek auth sözleşmesi; `auth.type: 'app' \| 'panel'` ile ayrışır. React'te **`usePage().props.auth` doğrudan okunmaz** — `useAppAuth()` / `usePanelAuth()` kullanılır. |
| `branding` | Uygulama kimliği (ad, logo, favicon). `useBranding()` ile okunur. |
| `flash` | Toast/flash yükleri (`sonner` ile gösterilir). |
| `navigation` | Sidebar menü ağacı; her istek için `MenuRegistry`'den, kullanıcının alanına göre, yetki-filtreli ve `order`-sıralı kurulur. |
| `name`, `sidebarOpen` | Uygulama adı ve sidebar durumu. |

::: warning İki auth tipini karıştırma
`AppUser` ve `PanelUser` asla karıştırılmaz; ikinci bir auth prop'u eklenmez.
Tipler [resources/js/types/auth.ts] içinde.
:::

## Hesap sahipliği ve kapsamı

`Account`, üye verisinin merkezî sahibidir. Üyeler (`user_type:member`) ve
üye-kapsamlı kayıtlar `account_id` üzerinden bağlanır; yöneticilerde
`account_id = null`'dır ve hesaplar arası (cross-account) çalışırlar.

Üye-kapsamlı modeller `use App\Concerns\BelongsToAccount` kullanır; bu trait
`account()` ilişkisini, **koşullu bir global scope**'u ve bir `creating` hook'unu
ekler. **`BindCurrentAccount`** middleware'i (alias `bind_account`, **yalnızca**
üye `app` grubunda) oturum açan kullanıcının hesabını bağlar; bağlıyken her
`BelongsToAccount` sorgusu `account_id`'ye göre otomatik süzülür ve yeni kayıtlar
`account_id`'yi otomatik alır. Bu bağlam dışında (panel/yönetim, seeder, job)
hiçbir şey bağlı değildir → scope yok, böylece yöneticiler hesaplar arası kalır.

::: danger Altın kural
**`account_id` asla istekten (request input) alınmaz.** Ya bağlı hesaptan türet
ya da ilişki üzerinden kur: `$account->things()->create([...])`.
:::

## Olay-tabanlı yan etkiler

Controller'lar **incedir**; iş kuralları servislerde durur. Her yan etki
(etkinlik kaydı, bildirim, e-posta) bir **`event() → listener`** zinciri üzerinden
akmalıdır — asla doğrudan controller/servisten değil. Listener'lar
**otomatik keşif** ile bağlanır (`EventServiceProvider $listen` dizisi yoktur).

Kabaca: ~80 olay, ~119 listener, ~22 bildirim, 12 mailable, 1 job, 0 policy.

```
Kullanıcı işlemi → Controller (ince) → Service (iş kuralı)
                                          └─ event(new XOldu(...))
                                                 ├─ LogX        (etkinlik kaydı)
                                                 └─ SendX       (bildirim → mail + DB)
```

## Yetkilendirme (özet)

Spatie laravel-permission, **arayüz-odaklı** (config dosyası veya artisan sync
yok). Üç parça birlikte çalışır: Super Admin için `Gate::before`,
`route_permission` middleware'i (rota adı = yetki adı) ve Yetkiler ekranı.
Ayrıntı: [Yetkilendirme](/sistemler/yetkilendirme).

## Yerelleştirme ve katılık

- Birincil dil **Türkçe (`tr`)**, İngilizce (`en`) paralel — ikisi `lang/`
  altında senkron tutulur.
- Geliştirme/testte `Model::preventLazyLoading()` N+1'i yakalar;
  üretimde `DB::prohibitDestructiveCommands()`.
- Her PHP dosyası `declare(strict_types=1);` ile başlar; her model `HasUuids`
  kullanır; tarih/saat için `CarbonImmutable`.

> Devamı: [Kod Yapısı](/genel/kod-yapisi).
