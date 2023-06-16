
# Herkobi Panel
Laravel ile yeni bir projeye başlayacak kişiler için Laravel Fortify üzerine geliştirdiğimiz arayüze (https://github.com/bulentsakarya/laravel-10-fortify-ui), Spatie Permission eklentisini de ekleyerek hazır bir panel oluşturduk.

Bu panel sayesinde kullanıcı yönetimi, yetki ve izin yönetimi gibi işlemleriniz hazır halde gelmektedir. Paneli indirdikten sonra sadece kendi sisteminizi yazmaya odaklanmanız yeterli.

Tamamen açık kaynak olarak dağıttığımız sistemi rahatlıkla kullanabilirsiniz.

## Kullanılan Paketler

- [Laravel Fortify UI](https://github.com/bulentsakarya/laravel-10-fortify-ui)
- [Laravel Fortify](https://laravel.com/docs/10.x/fortify)
- [Spatie Permission](https://github.com/spatie/laravel-permission)
- [Php Flasher Notfy](https://github.com/php-flasher/flasher-notyf-laravel)
- [Laravel 10 Türkçe Dil Dosyaları](https://github.com/laravel-tr/Laravel10-lang)
- [jQuery 3.7.0](https://jquery.com/)
- [Bootstrap 5.3](https://github.com/twbs)
- [Simplebar](https://github.com/Grsmto/simplebar)
- [Remixicon](https://github.com/Remix-Design/RemixIcon)

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

### Yol Haritası
- Genel ayarlar sayfası yapılacak. Kullanıcı bazlı tari formatı, saat dilimi ve para birimi tanımlama, dil tanımlama ayarları yapılacak. Yöneticiler için ek olarak UserType=USER ve UserType=ADMIN için varsayılan yetki seçimleri yapılacak.
- Dil yönetim sistemi oluşturulacak.
- Kurulan loglama sistemi tüm modüllere eklenecek ve yapılan işleme göre açıklamaları özelleştirilecek
- Oturum bilgileri için detaylı loglama yapılacak
- Kullanıcı detay sayfasında ki yetkiler ve izinler sayfası düzenlenecek. Bu bölümden ek yetki ve özel izinler tanımalanacak
- Yönetici eklenirken izin alanı seçiminde seçilmiş olan yetkiye ait değerler otomatik seçili getirilecek
- Kullanıcı kategorileri sistemi yapılacak
- Kullanıcı/Yönetici listeleme sayfasında kullanıcı durumları işlenecek. Sayfa düzenlenecek.
- Kullanıcı detay sayfasında kullanıcının kendisine ait loglar gösterilecek
- Laravel logları super admin için görüntülenecek
- Profil sayfalarında Super Admin dışındaki tüm kullanıcılar için hesabı askıya alma ve dondurma işlemi yapılacak
- Kullanıcı detay sayfasında UserStatus değeri güncellenecek
- Blade dosyalarında izinler için gerekli kontroller yapılacak. Navigasyon kullanıcı türüne göre elden geçirilecek.
- Ana sayfa kullanıcılar, yöneticiler ve super admin için güncellenecek
- Kullanıcı detay sayfasında kullanıcıya not ekleme alanı eklenecek
- Yönetici tarafı admin guard'ına taşınacak

### Ekran Görüntüleri
![Üye Girişi](https://i.hizliresim.com/ga12pxb.png)

![Şifremi Unuttum](https://i.hizliresim.com/j6v5pxd.png)

![Üye Ol](https://i.hizliresim.com/bdtryfb.png)

![Panel Ana Sayfa](https://i.hizliresim.com/t1r5i16.png)

![Kullanıcılar](https://i.hizliresim.com/le41kim.png)

![Yöneticiler](https://i.hizliresim.com/cs12gl8.png)

![Yetkiler](https://i.hizliresim.com/p4fe4rv.png)

![İzinler](https://i.hizliresim.com/br9dldp.png)

![İzin Grupları](https://i.hizliresim.com/kf9gv55.png)

## Lisans
Herkobi Panel, MIT (https://opensource.org/license/mit/) lisansı ile lisanslanan açık kaynak bir yazılımdır.
