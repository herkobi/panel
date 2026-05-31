# Panel — Araçlar

*Araçlar* grubu üç ekran içerir: **Etkinlik Kayıtları**, **Ön Bellek Yönetimi**
ve **Tanımlamalar**.

## Etkinlik Kayıtları

![Etkinlik kayıtları](/images/tools-activity.png)

`spatie/laravel-activitylog` üzerine kuruludur. Ekran:

- Olay adlarını **Türkçeye** yerelleştirir.
- Kaydı oluşturan kullanıcı türüne göre **filtreler** (Yönetici / Üye) —
  `whereHasMorph` ile.
- Subject (etkilenen kayıt) sınıflarını Türkçe etiketlere çevirir
  (`ActivitySubjectLabels`).

Girişler ayrıca `yadahan/laravel-authentication-log` ile takip edilir (oturum
açma kayıtları). Rota/yetki: `panel.tools.activity`.

## Ön Bellek Yönetimi

![Ön bellek yönetimi](/images/tools-cache.png)

Uygulama önbelleğini yönetmek için araç ekranı. Rota/yetki: `panel.tools.cache`.

## Tanımlamalar

![Tanımlamalar — Bölgeler](/images/tools-definitions-country.png)

Sistem genelinde kullanılan referans verileri. Menüde **Diller**, **Bölgeler**
(ülke/şehir/ilçe), **Para Birimleri** ve **Vergi Oranları** olarak gruplanır.

### Ortak davranış

- Kayıtlar **varsayılan olarak pasif** oluşturulur.
- Durum, oluşturma/düzenleme formundan değil, tablodaki **özel `/status` uç
  noktasından** açılıp kapatılır (kendi etkinlik olayı vardır).
- **`DefinitionGuard`** koruması:
  - Varsayılan seçili bir kayıt (ülke/para birimi/vergi/dil/saat dilimi)
    pasifleştirilemez veya silinemez.
  - Alt kaydı olan bir kayıt silinemez (örn. şehri olan ülke).

### Para birimleri

![Tanımlamalar — Para Birimleri](/images/tools-definitions-currency.png)

Para birimi kaydı `thousands_separator` (binlik ayraç) ve `decimal_separator`
(ondalık ayraç) taşır. Vergi oranları ise `sort_order` ile sıralanır.

İlgili rota/yetki örnekleri: `panel.tools.definitions.languages.index`,
`panel.tools.definitions.countries.index`,
`panel.tools.definitions.currencies.index`,
`panel.tools.definitions.taxes.index`.

::: tip Silinenler
Tanımlama ekranlarının çoğu bir **"silinenler"** görünümüne sahiptir; yumuşak
silinen kayıtlar buradan görüntülenip geri alınabilir.
:::
