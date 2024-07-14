# Herkobi Panel (Beta 1)

Laravel ile yeni bir projeye başlayacak kişiler için Laravel Fortify, Spatie Permission, rap2hpoutre/laravel-log-viewer ve Spatie Health paketlerini ekleyerek Tabler arayüzünü de kullanarak hazır bir panel oluşturduk.

Bu panel sayesinde kullanıcı yönetimi, etkinlik takibi, yetki ve izin yönetimi gibi işlemleriniz hazır halde gelmektedir. Paneli indirdikten sonra sadece kendi sisteminizi yazmaya odaklanmanız yeterli.

Ücretsiz ve açık kaynak olarak dağıttığımız sistemi test edip eksik ve hataları bildirirseniz seviniriz.

## Kullanılan Paketler

-   [Laravel Fortify](https://laravel.com/docs/10.x/fortify)
-   [Tabler Arayüzü](https://tabler.io)
-   [Spatie Permission](https://github.com/spatie/laravel-permission)
-   [Spatie Laravel Activitylog](https://github.com/spatie/laravel-activitylog)
-   [Spatie Laravel Health](https://github.com/spatie/laravel-health)
-   [rap2hpoutre laravel Log Viewer](https://github.com/rap2hpoutre/laravel-log-viewer)

## Kurulum

Paketi indirdikten sonra seed'ler ile birlikte migrate etmeniz yeterlidir. Super Admin, Admin ve User yetkileri ve kullanıcıları otomatik tanımlanır.

### Kullanıcı Bilgileri

**Süper Admin Bilgileri**
Kullanıcı Adı: super@super.com
Şifre: password

**Admin Bilgileri**
Kullanıcı Adı: admin@admin.com
Şifre: password

**Kullanıcı Bilgileri**
Kullanıcı Adı: user@user.com
Şifre: password

### 15 Temmuz 2024 Beta 2

-   Paket güncelleme,
-   Role ve izin yönetimi düzenleme,
-   User kullanımı için trait tanımlama
-   Ön yüz için düzenleme
-   Hata ve tasarım düzeltmeleri

### Yol Haritası

-   Çeviriler tamamlanacak
-   Dil yönetim sistemi oluşturulacak.
-   Yedekleme sistemi dahil edilecek
-   Kullanıcı bazlı özel yetkilendirme tanımlanacak

## Lisans

Herkobi Panel, MIT (https://opensource.org/license/mit/) lisansı ile lisanslanan açık kaynak bir yazılımdır.
