<?php

declare(strict_types=1);

use App\Models\Country;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;

test('admin can view general settings with definition options', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('panel.settings.general.edit'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('panel/settings/general/index')
            ->has('settings')
            ->has('countries.data')
            ->has('currencies.data')
            ->has('taxes.data')
            ->has('languages.data')
            ->has('timezones')
        );
});

test('settings seeder stores turkiye defaults', function () {
    $country = Country::query()->where('code', 'TR')->firstOrFail();
    $currency = Currency::query()->where('code', 'TRY')->firstOrFail();
    $tax = Tax::query()->where('name', 'KDV %20')->firstOrFail();

    expect(Setting::get('app_name'))->toBe('Herkobi Panel')
        ->and(Setting::get('default_country_id'))->toBe($country->id)
        ->and(Setting::get('default_currency_id'))->toBe($currency->id)
        ->and(Setting::get('default_tax_id'))->toBe($tax->id)
        ->and(Setting::get('default_language_code'))->toBe('tr')
        ->and(Setting::get('default_timezone'))->toBe('Europe/Istanbul');
});

test('admin can update general settings and upload branding images', function () {
    Storage::fake('public');

    $admin = User::factory()->admin()->create();
    $country = Country::query()->active()->firstOrFail();
    $currency = Currency::query()->active()->firstOrFail();
    $tax = Tax::query()->active()->firstOrFail();
    $language = Language::query()->active()->firstOrFail();

    $this->actingAs($admin)
        ->post(route('panel.settings.general.update'), [
            'app_name' => 'Panel App',
            'app_slogan' => 'Operasyon merkezi',
            'logo_path' => UploadedFile::fake()->image('logo.jpg'),
            'logo_dark_path' => UploadedFile::fake()->image('logo-dark.jpeg'),
            'favicon_path' => UploadedFile::fake()->image('favicon.png'),
            'default_country_id' => $country->id,
            'default_currency_id' => $currency->id,
            'default_tax_id' => $tax->id,
            'default_language_code' => $language->code,
            'default_timezone' => 'Europe/Istanbul',
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect()
        ->assertSessionHas('toast.type', 'success');

    foreach ([
        'app_name' => 'Panel App',
        'app_slogan' => 'Operasyon merkezi',
        'default_country_id' => $country->id,
        'default_currency_id' => $currency->id,
        'default_tax_id' => $tax->id,
        'default_language_code' => $language->code,
        'default_timezone' => 'Europe/Istanbul',
    ] as $key => $value) {
        $this->assertDatabaseHas('settings', [
            'key' => $key,
            'value' => $value,
        ]);
    }

    foreach (['logo_path', 'logo_dark_path', 'favicon_path'] as $key) {
        $path = Setting::query()->where('key', $key)->value('value');

        expect($path)->toBeString()->toStartWith('media/');
        Storage::disk('public')->assertExists($path);
    }

    $this->assertDatabaseHas('activity_log', [
        'log_name' => 'settings',
        'event' => 'updated',
        'causer_id' => $admin->id,
    ]);
});

test('admin can upload a branding asset immediately', function () {
    Storage::fake('public');

    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('panel.settings.general.asset.upload'), [
            'key' => 'logo_path',
            'file' => UploadedFile::fake()->image('logo.png'),
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $path = Setting::get('logo_path');

    expect($path)->toBeString()->toStartWith('media/');
    Storage::disk('public')->assertExists($path);
});

test('admin can remove a branding asset immediately', function () {
    Storage::fake('public');

    $admin = User::factory()->admin()->create();

    Setting::updateOrCreate(
        ['key' => 'logo_path'],
        ['value' => 'media/logo-existing.png', 'group' => 'branding'],
    );
    Storage::disk('public')->put('media/logo-existing.png', 'binary');

    $this->actingAs($admin)
        ->delete(route('panel.settings.general.asset.destroy'), [
            'key' => 'logo_path',
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    expect(Setting::get('logo_path'))->toBeNull();
    Storage::disk('public')->assertMissing('media/logo-existing.png');
});

test('asset upload rejects unknown keys', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('panel.settings.general.asset.upload'), [
            'key' => 'app_name',
            'file' => UploadedFile::fake()->image('x.png'),
        ])
        ->assertSessionHasErrors('key');
});

test('branding uploads are limited to jpg jpeg and png', function () {
    Storage::fake('public');

    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('panel.settings.general.update'), [
            'logo_path' => UploadedFile::fake()->image('logo.gif'),
        ])
        ->assertSessionHasErrors('logo_path');
});
