# App — Üye Alanı

Üye uygulaması `/app` ön ekiyle çalışır ve şu middleware yığınını taşır:
`auth, verified, user_type:member, active_user, write_access, bind_account`.
Yalnızca **üye** (`user_type:member`) kullanıcılar erişebilir.

Panelden temel farkı: **`bind_account`** middleware'i burada çalışır. Oturum açan
üyenin hesabı bağlanır ve bağlı olduğu sürece tüm `BelongsToAccount` sorguları
otomatik olarak `account_id`'ye göre süzülür. Böylece her üye yalnızca kendi
hesabının verisini görür.

## Başlangıç ekranı

![Üye başlangıç ekranı](/images/app-dashboard.png)

Üyenin giriş ekranı. Sidebar yine veri-odaklıdır (`navigation` prop'u); app
alanının çekirdek menüsü **Platform** grubunda **Başlangıç** ve **Hesabım**
öğelerini içerir.

## Hesabım

![Hesabım](/images/app-account.png)

Üyenin kendi hesap bilgileri. Hesap (`Account`), üye verisinin merkezî sahibidir;
üyeye ait kayıtlar bu hesaba bağlanır. `account_id` asla istekten alınmaz — bağlı
hesaptan türetilir.

Rota: `app.account`.

## Profil & Güvenlik

Üye tarafında da panel ile aynı kişisel ekranlar bulunur: **Profil**,
**Güvenlik** (2FA), **Oturumlar**, **Bildirimler** ve **Görünüm**. Bu ekranların
davranışı panel tarafıyla aynıdır; ayrıntı için
[Panel → Profil & Güvenlik](/panel/profil) sayfasına bakabilirsiniz.

![Üye profili](/images/app-profile.png)

::: tip Tek sözleşme, iki alan
App ve panel aynı `auth` sözleşmesini paylaşır; ayrım `auth.type` iledir. React'te
üye alanında `useAppAuth()`, panel alanında `usePanelAuth()` kullanılır — ikisi
asla karıştırılmaz.
:::
