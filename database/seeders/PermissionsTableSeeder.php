<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
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
                'name' => 'bac.management',
                'desc' => 'EFT/Havale Ödeme Yönetimi',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 0,
                'name' => 'cc.management',
                'desc' => 'Kredi Kartı İle Ödeme Yönetimi',
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
                'parent_id' => 1,
                'name' => 'app.update',
                'desc' => 'Uygulama Ayarlarını Güncelle',
                'guard_name' => 'web'
            ],
            [
                'parent_id' => 2,
                'name' => 'user.index',
                'desc' => 'Kullanıcıları Görüntüle',
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
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }
    }
}
