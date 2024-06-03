<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'parent_id' => 0,
                'name' => 'app.management',
                'desc' => 'Uygulama Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 0,
                'name' => 'user.management',
                'desc' => 'Kullanıcı Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 0,
                'name' => 'role.management',
                'desc' => 'Yetki Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 0,
                'name' => 'permission.management',
                'desc' => 'İzin Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 0,
                'name' => 'gateway.management',
                'desc' => 'Ödeme Yöntemi Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 0,
                'name' => 'tax.management',
                'desc' => 'Vergi Bilgileri Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 0,
                'name' => 'currency.management',
                'desc' => 'Para Birimleri Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 0,
                'name' => 'location.management',
                'desc' => 'Konum Bilgisi Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 0,
                'name' => 'language.management',
                'desc' => 'Dil Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 0,
                'name' => 'page.management',
                'desc' => 'Sayfa Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 0,
                'name' => 'account.management',
                'desc' => 'Hesap Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 0,
                'name' => 'tools.authlogs.management',
                'desc' => 'Oturum Kayıtları Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 0,
                'name' => 'tools.activity.management',
                'desc' => 'Kullanıcı Eylemleri Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 0,
                'name' => 'tools.cache.management',
                'desc' => 'Önbellek Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 1,
                'name' => 'app.update',
                'desc' => 'Uygulama Ayarlarını Güncelle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 2,
                'name' => 'user.create',
                'desc' => 'Kullanıcı Ekle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 2,
                'name' => 'user.detail',
                'desc' => 'Kullanıcı Bilgilerini Gör',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 2,
                'name' => 'user.activity',
                'desc' => 'Kullanıcı İşlemlerini Gör',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 2,
                'name' => 'user.permission',
                'desc' => 'Kullanıcı İzin ve Yetkilerini Gör',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 2,
                'name' => 'user.permission.update',
                'desc' => 'Kullanıcı İzin ve Yetkilerini Güncelle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 2,
                'name' => 'user.autlogs',
                'desc' => 'Kullanıcı Oturum Kayıtlarını Gör',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 2,
                'name' => 'user.status.update',
                'desc' => 'Kullanıcı Durumunu Güncelle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 2,
                'name' => 'user.email.update',
                'desc' => 'Kullanıcı E-posta Adresini Güncelle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 2,
                'name' => 'user.email.verified',
                'desc' => 'Kullanıcı E-posta Adresini Onayla',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 2,
                'name' => 'user.email.send',
                'desc' => 'Kullanıcı E-posta Onay Linki Gönder',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 2,
                'name' => 'user.password.update',
                'desc' => 'Kullanıcı Şifresini Değiştir',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 2,
                'name' => 'user.password.reset',
                'desc' => 'Kullanıcı Şifre Yenileme Linki Gönder',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 3,
                'name' => 'role.create',
                'desc' => 'Yetki Ekle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 3,
                'name' => 'role.update',
                'desc' => 'Yetki Güncelle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 3,
                'name' => 'role.delete',
                'desc' => 'Yetki Sil',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 3,
                'name' => 'role.sync',
                'desc' => 'İzin Tanımla',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 4,
                'name' => 'permission.create',
                'desc' => 'İzin Ekle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 4,
                'name' => 'permission.update',
                'desc' => 'İzin Güncelle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 4,
                'name' => 'permission.delete',
                'desc' => 'İzin Sil',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 5,
                'name' => 'bac.create',
                'desc' => 'EFT/Havale Ödeme Yöntemi Ekle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 5,
                'name' => 'bac.update',
                'desc' => 'EFT/Havale Ödeme Yöntemi Güncelle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 5,
                'name' => 'bac.delete',
                'desc' => 'EFT/Havale Ödeme Yöntemi Sil',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 5,
                'name' => 'cc.update',
                'desc' => 'Kredi Kartı İle Ödeme Yöntemi Güncelle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 6,
                'name' => 'tax.create',
                'desc' => 'Vergi Bilgisi Ekle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 6,
                'name' => 'tax.update',
                'desc' => 'Vergi Bilgisi Güncelle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 6,
                'name' => 'tax.delete',
                'desc' => 'Vergi Bilgisi Sil',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 7,
                'name' => 'currency.create',
                'desc' => 'Para Birimi Ekle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 7,
                'name' => 'currency.update',
                'desc' => 'Para Birimi Güncelle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 7,
                'name' => 'currency.delete',
                'desc' => 'Para Birimi Sil',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 8,
                'name' => 'location.create',
                'desc' => 'Konum Bilgisi Ekle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 8,
                'name' => 'location.update',
                'desc' => 'Konum Bilgisi Güncelle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 8,
                'name' => 'location.delete',
                'desc' => 'Konum Bilgisi Sil',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 9,
                'name' => 'language.create',
                'desc' => 'Arayüz Dili Ekle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 9,
                'name' => 'language.update',
                'desc' => 'Arayüz Dili Güncelle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 9,
                'name' => 'language.delete',
                'desc' => 'Arayüz Dili Sil',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 9,
                'name' => 'language.translate',
                'desc' => 'Arayüz Dili Çevir',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 10,
                'name' => 'page.create',
                'desc' => 'Sayfa Ekle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 10,
                'name' => 'page.update',
                'desc' => 'Sayfa Düzenle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 10,
                'name' => 'page.delete',
                'desc' => 'Sayfa Sil',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 11,
                'name' => 'account.create',
                'desc' => 'Hesap Ekle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 11,
                'name' => 'account.detail',
                'desc' => 'Hesap Bilgilerini Gör',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 11,
                'name' => 'account.activity',
                'desc' => 'Hesap İşlemlerini Gör',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 11,
                'name' => 'account.permission',
                'desc' => 'Hesap İzin ve Yetkilerini Gör',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 11,
                'name' => 'account.permission.update',
                'desc' => 'Hesap İzin ve Yetkilerini Güncelle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 11,
                'name' => 'account.autlogs',
                'desc' => 'Hesap Oturum Kayıtlarını Gör',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 11,
                'name' => 'account.status.update',
                'desc' => 'Hesap Durumunu Güncelle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 11,
                'name' => 'account.email.update',
                'desc' => 'Hesap E-posta Adresini Güncelle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 11,
                'name' => 'account.email.verified',
                'desc' => 'Hesap E-posta Adresini Onayla',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 11,
                'name' => 'account.email.send',
                'desc' => 'Hesap E-posta Onay Linki Gönder',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 11,
                'name' => 'account.password.update',
                'desc' => 'Hesap Şifresini Değiştir',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 11,
                'name' => 'account.password.reset',
                'desc' => 'Hesap Şifre Yenileme Linki Gönder',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 12,
                'name' => 'tools.accounts.auth.logs',
                'desc' => 'Hesap Oturum Kayıtları Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 12,
                'name' => 'tools.user.auth.logs',
                'desc' => 'Kullanıcı Oturum Kayıtları Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 12,
                'name' => 'tools.auth.logs.detail',
                'desc' => 'Oturum Kayıtları Bilgisi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 13,
                'name' => 'tools.accounts.activities',
                'desc' => 'Hesap Eylemleri Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 13,
                'name' => 'tools.users.activities',
                'desc' => 'Kullanıcı Eylemleri Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 14,
                'name' => 'tools.cache.cache',
                'desc' => 'Uygulama Önbelliği Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 14,
                'name' => 'tools.cache.optimize',
                'desc' => 'Sistem Önbelliği Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 14,
                'name' => 'tools.cache.view',
                'desc' => 'Görünüm Önbelliği Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 14,
                'name' => 'tools.cache.route',
                'desc' => 'Rota Önbelliği Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 14,
                'name' => 'tools.cache.config',
                'desc' => 'Yapılandırma Önbelliği Yönetimi',
                'guard_name' => 'web'
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $allPermissions = Permission::all();
        $role = Role::where('name', 'Admin')->first();

        $role->givePermissionTo($allPermissions);
    }
}
