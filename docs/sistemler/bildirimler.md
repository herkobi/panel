# Bildirimler & E-posta

Tüm bildirim ve e-postalar tek bir standartla akar. Amaç: hem uygulama-içi
bildirim satırını hem de (kuyruğa alınmış) e-postayı **tek bir noktadan**
yönetmek.

## Standart akış

```
event(new XOldu(...))
   └─ SendX (listener, ince)
        └─ $notifiable->notify(new XNotification(...))
               ├─ toArray()  → uygulama-içi bildirim satırı (database)
               └─ toMail()   → Mailable döndürür (mail, kuyrukta)
```

- **`Send{X}` listener'ı incedir:** gerekli URL/token'ı hazırlar ve
  `$notifiable->notify(new {X}Notification(...))` çağırır.
- **`{X}Notification implements ShouldQueue`:** `via = ['mail','database']` (veya
  alt kümesi) bildirir, `toMail()` ile Mailable'ı döndürür, `toArray()` ile
  uygulama-içi satırı yazar.
- Bildirim, hem uygulama-içi hem (kuyruklu) mail için **tek orkestrasyon
  noktasıdır**.

::: warning Rutin mail için Job kullanma
Rutin mail bir listener'dan Job ile gönderilmez. Job'a yalnızca mail'in bağımsız
bir yaşam döngüsüne (özel kuyruk/retry/batch) ihtiyacı olduğunda başvurulur.
Bugün tek Job: `Auth/DetectNewDeviceLogin`.
:::

## Mail şablonları

Mail görünümleri `resources/views/mail/` altında yaşar. Mail başlığı markalama
logosunu kullanır (bkz. [Markalama](/sistemler/markalama)).

## Toast / flash mesajları

Controller'lar şu şekilde flash eder:

```php
->with('toast', ['type' => 'success|info|warning|error', 'message' => __('...')])
```

`use-flash-toast` hook'u bunu **sonner** ile render eder (üstte ortalı,
`richColors`). Alan-içi (domain) korumalar, kullanıcıya dönük uyarıları
render-edilebilir bir exception fırlatarak yüzeye çıkarır — örn.
`DefinitionGuardException` jenerik 422 yerine bir `warning` toast döndürür.

## Etkinlik kaydı ile ilişki

Bildirim göndermek ile etkinlik kaydı yazmak ayrı listener'lardır ama aynı olaydan
beslenir. `Log{X}` listener'ı `spatie/laravel-activitylog`'a yazar (genelde
`LogsActivity` concern'i ile DRY). Etkinlikler **Araçlar → Etkinlik Kayıtları**
ekranında görüntülenir (bkz. [Araçlar](/panel/araclar#etkinlik-kayitlari)).
