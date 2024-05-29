<?php

namespace Database\Seeders;

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
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Dil: Türkçe
        Language::factory()->create();
        //Dil: İngilizce
        Language::factory()->otherLanguage()->create();
        //Ülkeler
        Country::factory()->create();
        //Şehirler
        State::factory()->create();
        //Para Birimleri
        Currency::factory()->create();
        //Vergi Bilgileri
        Tax::factory()->create();
        // Varsayılan kayıt (EFT/Havale İle Ödeme)
        Payment::factory()->create();
        // Kredi kartı ile ödeme için kayıt
        Payment::factory()->forCreditCardPayment()->create();
        // Varsayılan kayıt (EFT/Havale İle Ödeme)
        Gateway::factory()->create();
        // Kredi kartı ile ödeme için kayıt
        Gateway::factory()->forCreditCardGateway()->create();
        //Süper Yönetici Rolü
        $superRole = Role::factory()->create();
        // Yönetici Rolü
        $adminRole = Role::factory()->adminRole()->create();
        // Kullanıcı Rolü
        $userRole = Role::factory()->userRole()->create();
        //Sistem Ayarları
        Setting::factory()->create();
        //Uygulama Ayarları
        Setting::factory()->appSettings()->create();
        //Sayfalar
        Page::factory()->create();
        //Süper Yönetici Hesabı ve Rolü
        $super = User::factory()->create();
        $super->assignRole([$superRole->id]);
        //Yönetici Hesabı ve Rolü
        $admin = User::factory()->adminUser()->create();
        $admin->assignRole([$adminRole->id]);
        //Kullanıcı Hesabı ve Rolü
        $user = User::factory()->normalUser()->create();
        $user->assignRole([$userRole->id]);
    }
}
