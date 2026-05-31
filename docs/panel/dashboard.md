# Panel — Başlangıç Ekranı

Yönetim paneli `/panel` ön ekiyle çalışır ve şu middleware yığınını taşır:
`auth, verified, user_type:admin, active_user, write_access, route_permission`.
Yalnızca **yönetici** (`user_type:admin`) kullanıcılar erişebilir.

![Panel başlangıç ekranı](/images/panel-dashboard.png)

## Sidebar (veri-odaklı menü)

Sol menü hardcode değildir; her istekte `MenuRegistry`'den, kullanıcının
yetkilerine göre süzülerek ve `order`'a göre sıralanarak kurulur ve `navigation`
prop'u olarak paylaşılır. Çekirdek menü şu gruplardan oluşur:

| Grup | Öğeler |
|---|---|
| **Platform** | Başlangıç · Üyeler (Üyeler, Yeni Üye) |
| **Araçlar** | Etkinlik Kayıtları · Ön Bellek Yönetimi · Tanımlamalar (Diller, Bölgeler, Para Birimleri, Vergi Oranları) |
| **Ayarlar** | Genel Ayarlar · Kullanıcılar (Kullanıcılar, Kullanıcı Ekle, Roller, Yetkiler) |

PHP, ikon olarak bir **string anahtar** gönderir (`'layoutGrid'`, `'users'` …);
React tarafı bunu `navigation-icons.ts` ile Lucide bileşenine çözer. Böylece
PHP↔JS sınırından bileşen referansı geçmez.

::: tip Daraltılmış mod
Sidebar ikon moduna daraltıldığında alt menüler **flyout dropdown** olarak açılır;
ayrı bir yeniden boyutlandırma çubuğu yoktur.
:::

![Sidebar — daraltılmış flyout](/images/sidebar-collapsed-flyout.png)

## Yetki ve görünürlük

Bir menü öğesi `permission` taşıyorsa, kullanıcı o yetkiye sahip değilse menüde
**görünmez**. Super Admin `Gate::before` ile her kontrolü geçtiğinden tüm menüyü
görür. Menünün rota koruması ile uyumu, **rota adı = yetki adı** konvansiyonundan
gelir; ayrıntı için [Yetkilendirme](/sistemler/yetkilendirme).
