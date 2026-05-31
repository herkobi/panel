# Panel — Profil & Güvenlik

Her kullanıcının kişisel alanı. Bu ekranlar **yetki-gated değildir** ve izin
keşfinden hariç tutulur (`panel.profile.*` rotaları `route_permission`'dan muaf).
Aynı yapı app (üye) tarafında da bulunur.

## Profil

![Profil](/images/profile.png)

Ad, e-posta ve temel hesap bilgileri. E-posta değişikliği doğrulama akışından
geçer (ilgili bildirim ve mail otomatik gönderilir).

## Güvenlik (2FA)

![Güvenlik — 2FA kurulumu](/images/profile-security-2fa.png)

Parola güncelleme ve **iki adımlı doğrulama (2FA / TOTP)**. Laravel Fortify ile
sağlanır: QR kod, kurtarma kodları ve doğrulama akışı hazırdır. Hassas işlemler
parola onayı (`confirm-password`) ister.

## Oturumlar

![Oturumlar](/images/profile-sessions.png)

Aktif oturumların listesi ve uzaktan kapatma. Oturum açma kayıtları
`yadahan/laravel-authentication-log` ile takip edilir; yeni cihaz girişleri
algılanır (`Auth/DetectNewDeviceLogin` job'u ile bilgilendirme).

## Bildirimler

![Bildirim tercihleri](/images/profile-notifications.png)

Uygulama-içi bildirimler ve tercihler. Bildirimler `via = ['mail','database']`
ile hem uygulama-içi satıra hem de (kuyruğa alınmış) e-postaya yazılır.

## Görünüm

![Görünüm — koyu tema](/images/profile-appearance-dark.png)

Açık / koyu / sistem tema seçimi (`next-themes`). Markalama, koyu tema için ayrı
bir logo (`logoDark`) destekler.
