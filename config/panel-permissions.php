<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Panel Permissions Registry
|--------------------------------------------------------------------------
|
| Panel rotalarına karşılık gelen izinler. Permission adı = route adı kuralı
| izlenir (ör. "panel.members.store"). RolePermissionSeeder bu listeyi
| Spatie permission tablosuna yazar. UI gruplandırma için her izine bir
| `group` ve insan-okur etiketi atanır.
|
| Özel izinler (rota adından türetilemeyenler):
|   - users.create.admin  : Yeni kullanıcıya "Admin" rolü atayabilme yetkisi.
|                           Sadece Super Admin rolünde bulunur.
|   - panel.settings.users.role : Kullanıcının rolünü değiştirme.
|
*/

return [
    /*
    | Tüm panel izinleri ve UI metadata.
    | format: 'permission.name' => ['group' => 'Grup', 'label' => 'Etiket']
    */
    'permissions' => [
        // Dashboard
        'panel.dashboard' => ['group' => 'Genel', 'label' => 'Panel Başlangıç'],

        // Üye Yönetimi
        'panel.members.index' => ['group' => 'Üyeler', 'label' => 'Üyeleri Listele'],
        'panel.members.create' => ['group' => 'Üyeler', 'label' => 'Üye Oluşturma Formu'],
        'panel.members.store' => ['group' => 'Üyeler', 'label' => 'Üye Oluştur'],
        'panel.members.show' => ['group' => 'Üyeler', 'label' => 'Üye Detay'],
        'panel.members.email.verify' => ['group' => 'Üyeler', 'label' => 'Üye E-postası Onayla'],
        'panel.members.email.change' => ['group' => 'Üyeler', 'label' => 'Üye E-postası Değiştir'],
        'panel.members.status' => ['group' => 'Üyeler', 'label' => 'Üye Durumu Güncelle'],

        // Araçlar — Activity & Cache
        'panel.tools.activity' => ['group' => 'Araçlar', 'label' => 'Etkinlik Kayıtları'],
        'panel.tools.cache' => ['group' => 'Araçlar', 'label' => 'Ön Bellek Yönetimi'],
        'panel.tools.cache.clear' => ['group' => 'Araçlar', 'label' => 'Ön Belleği Temizle'],

        // Tanımlamalar — Diller
        'panel.tools.definitions.languages.index' => ['group' => 'Tanımlamalar / Diller', 'label' => 'Listele'],
        'panel.tools.definitions.languages.deleted' => ['group' => 'Tanımlamalar / Diller', 'label' => 'Silinenler'],
        'panel.tools.definitions.languages.store' => ['group' => 'Tanımlamalar / Diller', 'label' => 'Oluştur'],
        'panel.tools.definitions.languages.update' => ['group' => 'Tanımlamalar / Diller', 'label' => 'Güncelle'],
        'panel.tools.definitions.languages.status' => ['group' => 'Tanımlamalar / Diller', 'label' => 'Durum Değiştir'],
        'panel.tools.definitions.languages.destroy' => ['group' => 'Tanımlamalar / Diller', 'label' => 'Sil'],
        'panel.tools.definitions.languages.restore' => ['group' => 'Tanımlamalar / Diller', 'label' => 'Geri Al'],
        'panel.tools.definitions.languages.force-delete' => ['group' => 'Tanımlamalar / Diller', 'label' => 'Kalıcı Sil'],

        // Tanımlamalar — Para Birimleri
        'panel.tools.definitions.currencies.index' => ['group' => 'Tanımlamalar / Para Birimleri', 'label' => 'Listele'],
        'panel.tools.definitions.currencies.deleted' => ['group' => 'Tanımlamalar / Para Birimleri', 'label' => 'Silinenler'],
        'panel.tools.definitions.currencies.store' => ['group' => 'Tanımlamalar / Para Birimleri', 'label' => 'Oluştur'],
        'panel.tools.definitions.currencies.update' => ['group' => 'Tanımlamalar / Para Birimleri', 'label' => 'Güncelle'],
        'panel.tools.definitions.currencies.status' => ['group' => 'Tanımlamalar / Para Birimleri', 'label' => 'Durum Değiştir'],
        'panel.tools.definitions.currencies.destroy' => ['group' => 'Tanımlamalar / Para Birimleri', 'label' => 'Sil'],
        'panel.tools.definitions.currencies.restore' => ['group' => 'Tanımlamalar / Para Birimleri', 'label' => 'Geri Al'],
        'panel.tools.definitions.currencies.force-delete' => ['group' => 'Tanımlamalar / Para Birimleri', 'label' => 'Kalıcı Sil'],

        // Tanımlamalar — Ülkeler
        'panel.tools.definitions.countries.index' => ['group' => 'Tanımlamalar / Ülkeler', 'label' => 'Listele'],
        'panel.tools.definitions.countries.deleted' => ['group' => 'Tanımlamalar / Ülkeler', 'label' => 'Silinenler'],
        'panel.tools.definitions.countries.store' => ['group' => 'Tanımlamalar / Ülkeler', 'label' => 'Oluştur'],
        'panel.tools.definitions.countries.update' => ['group' => 'Tanımlamalar / Ülkeler', 'label' => 'Güncelle'],
        'panel.tools.definitions.countries.status' => ['group' => 'Tanımlamalar / Ülkeler', 'label' => 'Durum Değiştir'],
        'panel.tools.definitions.countries.destroy' => ['group' => 'Tanımlamalar / Ülkeler', 'label' => 'Sil'],
        'panel.tools.definitions.countries.restore' => ['group' => 'Tanımlamalar / Ülkeler', 'label' => 'Geri Al'],
        'panel.tools.definitions.countries.force-delete' => ['group' => 'Tanımlamalar / Ülkeler', 'label' => 'Kalıcı Sil'],

        // Tanımlamalar — Şehirler
        'panel.tools.definitions.countries.cities.index' => ['group' => 'Tanımlamalar / Şehirler', 'label' => 'Listele'],
        'panel.tools.definitions.countries.cities.deleted' => ['group' => 'Tanımlamalar / Şehirler', 'label' => 'Silinenler'],
        'panel.tools.definitions.countries.cities.store' => ['group' => 'Tanımlamalar / Şehirler', 'label' => 'Oluştur'],
        'panel.tools.definitions.countries.cities.update' => ['group' => 'Tanımlamalar / Şehirler', 'label' => 'Güncelle'],
        'panel.tools.definitions.countries.cities.status' => ['group' => 'Tanımlamalar / Şehirler', 'label' => 'Durum Değiştir'],
        'panel.tools.definitions.countries.cities.destroy' => ['group' => 'Tanımlamalar / Şehirler', 'label' => 'Sil'],
        'panel.tools.definitions.countries.cities.restore' => ['group' => 'Tanımlamalar / Şehirler', 'label' => 'Geri Al'],
        'panel.tools.definitions.countries.cities.force-delete' => ['group' => 'Tanımlamalar / Şehirler', 'label' => 'Kalıcı Sil'],

        // Tanımlamalar — İlçeler
        'panel.tools.definitions.countries.cities.districts.index' => ['group' => 'Tanımlamalar / İlçeler', 'label' => 'Listele'],
        'panel.tools.definitions.countries.cities.districts.deleted' => ['group' => 'Tanımlamalar / İlçeler', 'label' => 'Silinenler'],
        'panel.tools.definitions.countries.cities.districts.store' => ['group' => 'Tanımlamalar / İlçeler', 'label' => 'Oluştur'],
        'panel.tools.definitions.countries.cities.districts.update' => ['group' => 'Tanımlamalar / İlçeler', 'label' => 'Güncelle'],
        'panel.tools.definitions.countries.cities.districts.status' => ['group' => 'Tanımlamalar / İlçeler', 'label' => 'Durum Değiştir'],
        'panel.tools.definitions.countries.cities.districts.destroy' => ['group' => 'Tanımlamalar / İlçeler', 'label' => 'Sil'],
        'panel.tools.definitions.countries.cities.districts.restore' => ['group' => 'Tanımlamalar / İlçeler', 'label' => 'Geri Al'],
        'panel.tools.definitions.countries.cities.districts.force-delete' => ['group' => 'Tanımlamalar / İlçeler', 'label' => 'Kalıcı Sil'],

        // Tanımlamalar — Vergi Oranları
        'panel.tools.definitions.taxes.index' => ['group' => 'Tanımlamalar / Vergiler', 'label' => 'Listele'],
        'panel.tools.definitions.taxes.deleted' => ['group' => 'Tanımlamalar / Vergiler', 'label' => 'Silinenler'],
        'panel.tools.definitions.taxes.store' => ['group' => 'Tanımlamalar / Vergiler', 'label' => 'Oluştur'],
        'panel.tools.definitions.taxes.update' => ['group' => 'Tanımlamalar / Vergiler', 'label' => 'Güncelle'],
        'panel.tools.definitions.taxes.status' => ['group' => 'Tanımlamalar / Vergiler', 'label' => 'Durum Değiştir'],
        'panel.tools.definitions.taxes.destroy' => ['group' => 'Tanımlamalar / Vergiler', 'label' => 'Sil'],
        'panel.tools.definitions.taxes.restore' => ['group' => 'Tanımlamalar / Vergiler', 'label' => 'Geri Al'],
        'panel.tools.definitions.taxes.force-delete' => ['group' => 'Tanımlamalar / Vergiler', 'label' => 'Kalıcı Sil'],

        // Ayarlar — Genel
        'panel.settings.general.edit' => ['group' => 'Ayarlar / Genel', 'label' => 'Görüntüle'],
        'panel.settings.general.update' => ['group' => 'Ayarlar / Genel', 'label' => 'Güncelle'],

        // Ayarlar — Kullanıcılar
        'panel.settings.users.index' => ['group' => 'Ayarlar / Kullanıcılar', 'label' => 'Listele'],
        'panel.settings.users.create' => ['group' => 'Ayarlar / Kullanıcılar', 'label' => 'Oluşturma Formu'],
        'panel.settings.users.store' => ['group' => 'Ayarlar / Kullanıcılar', 'label' => 'Oluştur'],
        'panel.settings.users.show' => ['group' => 'Ayarlar / Kullanıcılar', 'label' => 'Detay'],
        'panel.settings.users.email.verify' => ['group' => 'Ayarlar / Kullanıcılar', 'label' => 'E-posta Onayla'],
        'panel.settings.users.email.change' => ['group' => 'Ayarlar / Kullanıcılar', 'label' => 'E-posta Değiştir'],
        'panel.settings.users.status' => ['group' => 'Ayarlar / Kullanıcılar', 'label' => 'Durum Güncelle'],
        'panel.settings.users.role' => ['group' => 'Ayarlar / Kullanıcılar', 'label' => 'Rolü Güncelle'],

        // Ayarlar — Roller ve Yetkiler
        'panel.settings.roles.index' => ['group' => 'Ayarlar / Roller', 'label' => 'Listele'],
        'panel.settings.roles.create' => ['group' => 'Ayarlar / Roller', 'label' => 'Oluşturma Formu'],
        'panel.settings.roles.store' => ['group' => 'Ayarlar / Roller', 'label' => 'Oluştur'],
        'panel.settings.roles.show' => ['group' => 'Ayarlar / Roller', 'label' => 'Detay/Düzenle'],
        'panel.settings.roles.update' => ['group' => 'Ayarlar / Roller', 'label' => 'Güncelle'],
        'panel.settings.roles.destroy' => ['group' => 'Ayarlar / Roller', 'label' => 'Sil'],

        // Özel — Rota adından türetilemeyen
        'users.create.admin' => ['group' => 'Özel Yetkiler', 'label' => 'Yeni Admin/Super Admin Atama Yetkisi'],
    ],

    /*
    | Kilitli (silinemez/değiştirilemez) sistem rolleri.
    | Bu roller seeder ile oluşturulur; UI'da düzenleme/silme butonu gizli olur.
    */
    'system_roles' => [
        'Super Admin' => [
            'description' => 'Tüm yetkilere sahip sistem rolü. Sadece bu rol yeni Admin/Super Admin atayabilir.',
            'is_default' => false,
        ],
        'Admin' => [
            'description' => 'Genel yönetici rolü. Yeni Admin atayamaz ve rol/yetki yönetimi yapamaz.',
            'is_default' => true,
        ],
    ],

    /*
    | Admin rolünün ELİNDE OLMAYACAK izinler.
    | Süper Admin tüm izinlere sahiptir; Admin bu listedekilerden YOKSUN olur.
    */
    'admin_excluded_permissions' => [
        // Yeni admin/super admin atama
        'users.create.admin',
        // Roller ve yetkiler yönetimi (sadece Super Admin)
        'panel.settings.roles.index',
        'panel.settings.roles.create',
        'panel.settings.roles.store',
        'panel.settings.roles.show',
        'panel.settings.roles.update',
        'panel.settings.roles.destroy',
    ],

    /*
    | Tüm panel kullanıcılarının zaten erişebileceği izinler (dashboard vb).
    | Bu izinler middleware kontrolünden muaftır; her admin/üye görür.
    */
    'baseline_permissions' => [
        'panel.dashboard',
    ],
];
