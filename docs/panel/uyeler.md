# Panel — Üyeler

**Üyeler**, sistemdeki member (`user_type:member`) kullanıcılarını ve onlara
bağlı **hesapları** (`Account`) yönetir. Menüde *Platform → Üyeler* altında
**Üyeler** (liste) ve **Yeni Üye** (ekleme) bulunur.

## Üye listesi

![Üye listesi](/images/panel-members-list.png)

- Sayfalı tablo (`DataPagination` + `PaginatedResource`).
- Her satır üye bilgisini ve durumunu gösterir; detay için satıra gidilir.

İlgili rota/yetki: `panel.members.index`.

## Yeni üye

![Yeni üye formu](/images/panel-members-create.png)

Yeni üye oluşturma formu. Üye oluşturma akışı **olay-tabanlıdır**: kayıt
sonrasında ilgili olay tetiklenir ve dinleyiciler hesabı hazırlama, bildirim ve
e-posta gönderimi gibi yan etkileri yürütür.

::: tip Hesap nasıl oluşur?
Üye hesabı yalnızca **e-posta doğrulandığında** oluşturulur (self-servis Fortify
doğrulaması veya yöneticinin onaylı üye eklemesi). Bu, `Account` provisioning
listener'ları tarafından yönetilir.
:::

İlgili rota/yetki: `panel.members.create`.

## Üye detayı

![Üye detayı](/images/panel-members-show.png)

Üyenin bilgileri, hesabı ve durumu. Durum değişiklikleri kendi uç noktaları
(endpoint) ve kendi etkinlik olayları üzerinden yapılır; her yıkıcı işlem
`ConfirmDelete` ile önce onaylanır.

## Hesap kapsamı hatırlatması

Üye verisi `account_id` üzerinden izole edilir. Yönetici tarafında (panel)
`bind_account` middleware'i **çalışmaz**, dolayısıyla yöneticiler hesaplar arası
görür. `account_id` asla istekten alınmaz. Ayrıntı:
[Mimari → Hesap kapsamı](/genel/mimari#hesap-sahipligi-ve-kapsami).
