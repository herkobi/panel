<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Gateway;
use App\Models\Language;
use App\Models\Payment;
use App\Models\Place;
use App\Models\Role;
use App\Models\Setting;
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
        // Normal Kullanıcı Rolü
        $userRole = Role::factory()->userRole()->create();
        // Demo Kullanıcı Rolü
        $demoRole = Role::factory()->demoRole()->create();

        //Sistem Ayarları
        Setting::factory()->create();
        //Uygulama Ayarları
        Setting::factory()->appSettings()->create();

        //Süper Yönetici Hesabı ve Rolü
        $super = User::factory()->create();
        $super->assignRole([$superRole->id]);
        //Yönetici Hesabı ve Rolü
        $admin = User::factory()->adminUser()->create();
        $admin->assignRole([$adminRole->id]);

        //Kullanıcı Hesapları
        $normal = User::factory()->normalUser()->create();
        $normal->assignRole([$userRole->id]);
        $draft = User::factory()->draftUser()->create();
        $draft->assignRole([$userRole->id]);
        $passive = User::factory()->passiveUser()->create();
        $passive->assignRole([$userRole->id]);
        $deleted = User::factory()->deletedUser()->create();
        $deleted->assignRole([$userRole->id]);
        $demo = User::factory()->demoUser()->create();
        $demo->assignRole([$demoRole->id]);

        $this->call([
            PermissionsSeeder::class,
            StateSeeder::class,
            PageSeeder::class,
        ]);
    }
}
