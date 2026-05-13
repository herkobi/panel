<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Status;
use App\Enums\UserStatus;
use App\Enums\UserType;
use App\Models\Account;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\District;
use App\Models\Language;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $language = Language::query()->updateOrCreate(
            ['code' => 'tr'],
            [
                'name' => 'Turkish',
                'native_name' => 'Türkçe',
                'status' => Status::Active,
                'sort_order' => 1,
            ],
        );

        Language::query()->updateOrCreate(
            ['code' => 'en'],
            [
                'name' => 'English',
                'native_name' => 'English',
                'status' => Status::Active,
                'sort_order' => 2,
            ],
        );

        Currency::query()->updateOrCreate(
            ['code' => 'TRY'],
            [
                'name' => 'Türk Lirası',
                'symbol' => '₺',
                'decimal_places' => 2,
                'status' => Status::Active,
                'sort_order' => 1,
            ],
        );

        Currency::query()->updateOrCreate(
            ['code' => 'USD'],
            [
                'name' => 'Amerikan Doları',
                'symbol' => '$',
                'decimal_places' => 2,
                'status' => Status::Active,
                'sort_order' => 2,
            ],
        );

        $country = Country::query()->updateOrCreate(
            ['code' => 'TR'],
            [
                'name' => 'Türkiye',
                'status' => Status::Active,
                'sort_order' => 1,
            ],
        );

        $this->call(TurkiyeLocationsSeeder::class);

        $city = City::query()
            ->whereBelongsTo($country)
            ->where('code', '34')
            ->firstOrFail();

        $district = District::query()
            ->whereBelongsTo($city)
            ->where('name', 'Kadıköy')
            ->firstOrFail();

        Tax::query()->updateOrCreate(
            ['name' => 'KDV %20'],
            [
                'rate' => 20,
                'status' => Status::Active,
            ],
        );

        Tax::query()->updateOrCreate(
            ['name' => 'KDV %10'],
            [
                'rate' => 10,
                'status' => Status::Active,
            ],
        );

        $this->call(SettingsSeeder::class);
        $this->call(RolePermissionSeeder::class);

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'status' => UserStatus::Active,
                'user_type' => UserType::Admin,
                'locale' => $language->code,
                'timezone' => 'Europe/Istanbul',
            ],
        );

        $secondAdmin = User::query()->updateOrCreate(
            ['email' => 'panel@admin.com'],
            [
                'name' => 'Panel Admin',
                'password' => Hash::make('password'),
                'status' => UserStatus::Active,
                'user_type' => UserType::Admin,
                'locale' => $language->code,
                'timezone' => 'Europe/Istanbul',
            ],
        );

        $member = User::query()->updateOrCreate(
            ['email' => 'user@user.com'],
            [
                'name' => 'Member User',
                'password' => Hash::make('password'),
                'status' => UserStatus::Active,
                'user_type' => UserType::Member,
                'locale' => $language->code,
                'timezone' => 'Europe/Istanbul',
            ],
        );

        $admin->forceFill(['email_verified_at' => now()])->save();
        $secondAdmin->forceFill(['email_verified_at' => now()])->save();
        $member->forceFill(['email_verified_at' => now()])->save();

        // admin@admin.com → Super Admin, diğer admin'ler → Admin.
        // Member kullanıcılarına rol atanmaz; panele erişimleri user_type middleware'i ile engellenir.
        $admin->syncRoles(['Super Admin']);
        $secondAdmin->syncRoles(['Admin']);

        foreach ([$admin, $secondAdmin, $member] as $user) {
            Account::query()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'title' => $user->name,
                    'address' => 'Örnek adres',
                    'postal_code' => '34000',
                    'country_id' => $country->id,
                    'city_id' => $city->id,
                    'district_id' => $district->id,
                ],
            );
        }
    }
}
