# Medya

Polimorfik bir medya sistemi; herhangi bir modele dosya/görsel iliştirmeyi sağlar.
Üç parçadan oluşur: `app/Models/Media.php`, `app/Services/Support/MediaService.php`
ve `app/Concerns/HasMedia.php`.

## `media` tablosu

Polimorfik `media` tablosu şu alanları taşır:

| Alan | Açıklama |
|---|---|
| `disk`, `path` | Depolama diski ve yol |
| `original_name`, `mime_type`, `size` | Dosya meta verisi |
| `collection` | Koleksiyon adı (örn. `gallery`, `cover`) |
| `sort_order` | Sıralama |
| `custom_properties` | Serbest biçimli JSON (örn. `alt`, `is_cover`, `focal`) |

`custom_properties` içindeki hiçbir alan zorunlu değildir; ihtiyaç oldukça
doldurulur.

## `MediaService`

Transactional ve otomatik `sort_order`'lı işlemler:

- `attach()` — bir modele medya iliştirir.
- `detach()` — kaldırır.
- `reorder()` — koleksiyon içinde yeniden sıralar.

## Erişim

- `Media::url()` — genel (public) dosyalar için doğrudan URL.
- `Media::temporaryUrl(?DateTimeInterface)` — özel (private) dosyalar için
  imzalı, süreli URL (varsayılan 5 dakika).

## Klasör düzeni

Medya, sahibine göre yönlendirilir (`HasMedia` içindeki `mediaAccountCode()`
hook'u):

```
Üye sahipli   → public/{account.code}     ve  private/{account.code}
Yönetici/genel → public/media              ve  private/media
```

## Modele ekleme

Bir model `use App\Concerns\HasMedia` ile şu yetenekleri kazanır: polimorfik
`media()` ilişkisi, `mediaIn($collection)` ve `firstMediaIn($collection)`.

::: tip Hazır ama bağlı değil
`media-gallery` React bileşeni tamamlanmış olarak gelir ancak şu an hiçbir ekrana
bağlı değildir — ihtiyaç anında kullanılmak üzere hazır bekler. Bu, bilinçli bir
scaffolding'dir; silinmemelidir.
:::
