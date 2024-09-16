<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Page;
use App\Models\Setting;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\UserMeta;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Süper Yönetici Hesabı ve Rolü
        $super = User::factory()->create();
        //Yönetici Hesabı ve Rolü
        $admin = User::factory()->adminUser()->create();
        //Kullanıcı Hesapları
        $normal = User::factory()->normalUser()->create();
        $draft = User::factory()->draftUser()->create();
        $passive = User::factory()->passiveUser()->create();
        $deleted = User::factory()->deletedUser()->create();
        $demo = User::factory()->demoUser()->create();

        /**
         * Kullanıcı klasörü oluşturuluyor.
         */
        $userTypes = ['super', 'admin', 'normal', 'draft', 'passive', 'deleted', 'demo'];

        foreach ($userTypes as $type) {
            $folderName = 'user_' . Str::random(12);

            if (!Storage::disk('public')->exists($folderName)) {
                Storage::disk('public')->makeDirectory($folderName);
            }

            UserMeta::create([
                'user_id' => ${$type}->id,
                'user_folder' => $folderName
            ]);
        }

        $this->call([
            SettingsTableSeeder::class,
            PagesTableSeeder::class,
        ]);
    }
}
