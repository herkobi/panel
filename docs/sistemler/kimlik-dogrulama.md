# Kimlik Doğrulama

Kimlik doğrulama **Laravel Fortify** ile sağlanır (frontend-agnostic auth
backend). Tüm auth ekranları React/Inertia ile gelir.

## Sağlanan akışlar

| Ekran | Rota | Açıklama |
|---|---|---|
| Giriş | `/login` | E-posta + parola, "beni hatırla" |
| Kayıt | `/register` | Yeni üye kaydı |
| Parolamı unuttum | `/forgot-password` | Sıfırlama bağlantısı gönderir |
| Parola sıfırla | `/reset-password` | Token ile yeni parola |
| E-posta doğrulama | `/verify-email` | Doğrulama akışı |
| 2FA doğrulama | two-factor-challenge | TOTP kodu / kurtarma kodu |
| Parola onayı | confirm-password | Hassas işlemler öncesi |

![Giriş ekranı](/images/auth-login.png)

## İki adımlı doğrulama (2FA)

TOTP tabanlı iki adımlı doğrulama hazırdır: QR kod ile kurulum, kurtarma kodları
ve giriş sırasında doğrulama akışı. Kullanıcı 2FA'yı kendi **Güvenlik**
ekranından açar (bkz. [Profil & Güvenlik](/panel/profil#guvenlik-2fa)).

## Yönlendirme ve koruma

- Giriş sonrası `/dashboard`, `user_type`'a göre `/panel` veya `/app`'e yönlendirir.
- Tedarikçi veya pasif kullanıcılar oturumdan çıkarılır.
- `verified` middleware'i e-posta doğrulamasını zorunlu kılar; `active_user`
  pasif hesapları engeller.

## Yeni cihaz girişi

Yeni bir cihazdan giriş algılandığında `Auth/DetectNewDeviceLogin` job'u
çalışır ve kullanıcı bilgilendirilir. Giriş kayıtları
`yadahan/laravel-authentication-log` ile tutulur ve **Oturumlar** ekranında
görüntülenir.

::: tip Auth özelleştirme
Fortify ekranlarını/akışlarını özelleştirirken `app/Actions/Fortify/*`,
`FortifyServiceProvider` ve `config/fortify.php` dosyalarına bakın.
:::
