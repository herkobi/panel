<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Gateway;
use App\Models\Language;
use App\Models\Page;
use App\Models\Payment;
use App\Models\Role;
use App\Models\Setting;
use App\Models\State;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Support\Str;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Language::factory()->create();
        Language::factory()->otherLanguage()->create();
        Country::factory()->create();
        Currency::factory()->create();
        Tax::factory()->create();

        // Varsayılan kayıt (EFT/Havale İle Ödeme)
        Payment::factory()->create();
        // Kredi kartı ile ödeme için kayıt
        Payment::factory()->forCreditCardPayment()->create();

        // Varsayılan kayıt (EFT/Havale İle Ödeme)
        Gateway::factory()->create();
        // Kredi kartı ile ödeme için kayıt
        Gateway::factory()->forCreditCardGateway()->create();

        //Roller
        $superRole = Role::create(['name' => 'Super Admin', 'type' => UserType::ADMIN, 'desc' => 'Süper yönetici rolü', 'guard_name' => 'web']);
        $adminRole = Role::create(['name' => 'Admin', 'type' => UserType::ADMIN, 'desc' => 'Yönetici rolü', 'guard_name' => 'web']);
        $userRole = Role::create(['name' => 'User', 'type' => UserType::USER, 'desc' => 'Kullanıcı rolü', 'guard_name' => 'web']);

        //Uygulama Ayarları
        $app_data = ['title' => 'Herkobi Panel', 'slogan' => 'Laravel SaaS Panel', 'logo' => 'herkobi-site-logo.png', 'favicon' => 'herkobi-favicon.png', 'email' => 'site@site.com'];
        $app_data = json_encode($app_data);
        $app_key = 'app';

        $app = Setting::create([
            'key' => $app_key,
            'value' => $app_data
        ]);

        //Sistem Ayarları
        $settings_data = ['userrole' => '3', 'adminrole' => '2', 'language' => 'tr', 'location' => 'TR', 'currency' => 'TRY', 'tax' => 'KDV', 'timezone' => 'Europe/Istanbul', 'dateformat' => 'd/m/Y', 'timeformat' => 'H:i'];
        $settings_data = json_encode($settings_data);
        $settings_key = 'settings';

        $settings = Setting::create([
            'key' => $settings_key,
            'value' => $settings_data
        ]);

        //Bölgeler
        $states = ['Adana', 'Adıyaman', 'Afyonkarahisar', 'Ağrı', 'Amasya', 'Ankara', 'Antalya', 'Aksaray', 'Ardahan', 'Artvin', 'Aydın', 'Balıkesir', 'Bartın', 'Batman', 'Bayburt', 'Bilecik', 'Bingöl', 'Bitlis', 'Bolu', 'Burdur', 'Bursa', 'Çanakkale', 'Çankırı', 'Çorum', 'Denizli', 'Diyarbakır', 'Düzce', 'Edirne', 'Elazığ', 'Erzincan', 'Erzurum', 'Eskişehir', 'Gaziantep', 'Giresun', 'Gümüşhane', 'Hakkâri', 'Hatay', 'Iğdır', 'Isparta', 'İstanbul', 'İzmir', 'Kahramanmaraş', 'Karabük', 'Karaman', 'Kars', 'Kastamonu', 'Kayseri', 'Kilis', 'Kırıkkale', 'Kırklareli', 'Kırşehir', 'Kocaeli', 'Konya', 'Kütahya', 'Malatya', 'Manisa', 'Mardin', 'Mersin', 'Muğla', 'Muş', 'Nevşehir', 'Niğde', 'Ordu', 'Osmaniye', 'Rize', 'Sakarya', 'Samsun', 'Siirt', 'Sinop', 'Sivas', 'Şanlıurfa', 'Şırnak', 'Tekirdağ', 'Tokat', 'Trabzon', 'Tunceli', 'Uşak', 'Van', 'Yalova', 'Yozgat', 'Zonguldak'];
        foreach($states as $state)
        {
            State::create([
                'status' => Status::ACTIVE,
                'title' => $state,
                'slug' => Str::slug($state),
                'country_id' => 1,
            ]);
        }

        //Sayfalar
        $pages = ['Gizlilik Politikası', 'Çerez Politikası', 'Kullanım Sözleşmesi', 'KVKK Politikası', 'Kullanıcı Aydınlatma Metni', 'Ziyaretçi Aydınlatma Metni', 'Üyelik Sözleşmesi', 'Hizmet Sözleşmesi'];
        foreach($pages as $page)
        {
            Page::create([
                'status' => Status::ACTIVE,
                'title' => $page,
                'slug' => Str::slug($page),
                'text' => '',
            ]);
        }

        $user = User::factory()->create();
        $user->assignRole([$superRole->id]);
    }
}
