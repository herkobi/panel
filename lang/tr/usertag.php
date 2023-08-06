<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Kullanıcı Etiket Sayfası İçerikleri
    |--------------------------------------------------------------------------
    |
    | Aşağıdaki metinler kullanıcı etiket sayfalarında yapılan işlemler sırasında
    | kullanıcılara gösterilen mesajlardır. Bu metinleri uygulamanızın
    | gereksinimlerine göre düzenlemekte özgürsünüz.
    |
    */
    /* Genel Sayfa Başlığı */
    'page.title' => 'Kullanıcı Etiketleri',

    /* Etiket Ekleme Formu */
    'create.form.title' => 'Etiket Ekle',
    'create.form.status.label' => 'Durum',
    'create.form.tag.label' => 'Etiket',
    'create.form.tag.placeholder' => 'Etiket Adı',
    'create.form.color.label' => 'Renk',
    'create.form.desc.label' => 'Açıklama',
    'create.form.desc.placeholder' => 'Etiket ile ilgili kısa bilgi',
    'create.form.submit.text' => 'Kaydet',

    /* Etiket Ekleme Form Sonucu */
    'create.success.title' => 'Başarılı',
    'create.success.message' => 'Etiket başarılı bir şekilde oluşturuldu',
    'create.success.button.text' => 'Tamam',
    'create.error.title' => 'Hata!',
    'create.error.button.text' => 'Tamam',

    /* Etiket Güncelleme Formu */
    'update.form.title' => 'Etiket Düzenle',
    'update.form.status.label' => 'Durum',
    'update.form.tag.label' => 'Etiket',
    'update.form.tag.placeholder' => 'Etiket Adı',
    'update.form.color.label' => 'Renk',
    'update.form.desc.label' => 'Açıklama',
    'update.form.desc.placeholder' => 'Etiket ile ilgili kısa bilgi',
    'update.form.submit.button.text' => 'Güncelle',
    'update.form.delete.button.text' => 'Etiketi Sil',

    /* Etiket Güncelleme Formu Sonucu */
    'update.success.message' => 'Etiket başarılı bir şekilde güncellendi',

    /* Kayıtlı Etiketler Tablosu */
    'tags.title' => 'Kayıtlı Etiketler',
    'table.status' => 'Durum',
    'table.tag' => 'Etiket Adı',
    'table.color' => 'Renk',
    'table.desc' => 'Açıklama',
    'table.process' => 'İşlemler',
    'table.color.text' => 'renk',
    'table.edit.text' => 'Düzenle',
    'table.users.text' => 'Kullanıcılar',

    /* Etiket Silme Onay Modalı */
    'delete.confirm.title' => 'Emin misiniz?',
    'delete.confirm.text' => 'Bu işlem geri alınamaz.',
    'delete.confirm.delete.button.text' => 'Evet, Etiketi Sil',
    'delete.confirm.cancel.button.text' => 'İptal Et',
    'delete.success.title.text' => 'Başarılı',
    'delete.success.message.text' => 'Etiket başarılı bir şekilde silindi',
    'delete.error.title.text' => 'Hata',
    'delete.error.message.text' => 'Etikete ait kullanıcılar bulunmaktadır. Önce onları kaldırınız.',

    /* Log Kayıtları */
    'activity.create.success' => ':authuser :name isimli yeni bir kullanıcı etiketi oluşturdu',
    'log.create.success' => ':authuser, :ip ip adresi üzerinden, :name isimli yeni bir kullanıcı etiketi oluşturdu',
    'log.create.error' => ':name, :ip adresi üzerinden, :tag isimli yeni bir kullanıcı etiketi oluştururken bir sorun ile karşılaştı: Hata içeriği :error',

    'activity.update.success' => ':authuser :name isimli etiketi güncelledi',
    'log.update.success' => ':authuser, :ip ip adresi üzerinden, :name isimli etiketi güncelledi',
    'log.update.error' => ':name, :ip adresi üzerinden, :tag isimli etiketi güncellerken bir sorun ile karşılaştı: Hata içeriği :error',

    'activity.delete.success' => ':authuser :name isimli etiketi sildi',
    'log.delete.success' => ':authuser, :ip ip adresi üzerinden, :name isimli etiketi sildi',
    'log.delete.error' => ':name, :ip adresi üzerinden, :tag isimli etiketi silerken bir sorun ile karşılaştı: Hata içeriği :error',
];
