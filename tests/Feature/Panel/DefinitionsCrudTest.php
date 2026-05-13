<?php

declare(strict_types=1);

use App\Enums\Status;
use App\Models\City;
use App\Models\Country;
use App\Models\Currency;
use App\Models\District;
use App\Models\Language;
use App\Models\Setting;
use App\Models\Tax;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

test('admin can manage panel definitions with activity logs', function (array $case) {
    $admin = User::factory()->admin()->create();
    $context = $case['context']();

    $this->actingAs($admin)
        ->post($case['store_route']($context), $case['store_payload']($context))
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    /** @var Model $model */
    $model = $case['model']::query()->where($case['lookup']($context))->firstOrFail();

    $this->assertDatabaseHas('activity_log', [
        'log_name' => $case['log_name'],
        'event' => 'created',
        'subject_id' => $model->id,
    ]);

    $this->actingAs($admin)
        ->put($case['update_route']($context, $model), $case['update_payload']($context, $model))
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $model->refresh();
    expect($model->{$case['updated_field']})->toBe($case['updated_value']);

    $this->assertDatabaseHas('activity_log', [
        'log_name' => $case['log_name'],
        'event' => 'updated',
        'subject_id' => $model->id,
    ]);

    $this->actingAs($admin)
        ->patch($case['status_route']($context, $model))
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    expect($model->refresh()->status)->toBe(Status::Passive);

    $this->assertDatabaseHas('activity_log', [
        'log_name' => $case['log_name'],
        'event' => 'deactivated',
        'subject_id' => $model->id,
    ]);

    $this->actingAs($admin)
        ->patch($case['status_route']($context, $model))
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    expect($model->refresh()->status)->toBe(Status::Active);

    $this->assertDatabaseHas('activity_log', [
        'log_name' => $case['log_name'],
        'event' => 'activated',
        'subject_id' => $model->id,
    ]);

    $this->actingAs($admin)
        ->delete($case['destroy_route']($context, $model))
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->assertSoftDeleted($model->getTable(), ['id' => $model->id]);

    $this->assertDatabaseHas('activity_log', [
        'log_name' => $case['log_name'],
        'event' => 'deleted',
        'subject_id' => $model->id,
    ]);

    $this->actingAs($admin)
        ->patch($case['restore_route']($context, $model))
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    expect($model->refresh()->deleted_at)->toBeNull();

    $this->assertDatabaseHas('activity_log', [
        'log_name' => $case['log_name'],
        'event' => 'restored',
        'subject_id' => $model->id,
    ]);

    $this->actingAs($admin)
        ->delete($case['destroy_route']($context, $model))
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->actingAs($admin)
        ->delete($case['force_delete_route']($context, $model))
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->assertDatabaseMissing($model->getTable(), ['id' => $model->id]);

    $this->assertDatabaseHas('activity_log', [
        'log_name' => $case['log_name'],
        'event' => 'force_deleted',
        'subject_id' => $model->id,
    ]);
})->with('definition cases');

test('default definitions cannot be deactivated or deleted', function (array $case) {
    $admin = User::factory()->admin()->create();
    $model = $case['model']();

    Setting::query()->updateOrCreate(
        ['key' => $case['setting_key']],
        ['value' => $case['setting_value']($model), 'group' => 'defaults'],
    );

    $this->actingAs($admin)
        ->patch($case['status_route']($model))
        ->assertSessionHasErrors('definition');

    expect($model->refresh()->status)->toBe(Status::Active);

    $this->actingAs($admin)
        ->delete($case['destroy_route']($model))
        ->assertSessionHasErrors('definition');

    expect($model->refresh()->deleted_at)->toBeNull();
})->with('default protected definition cases');

test('countries with cities and cities with districts cannot be deleted', function () {
    $admin = User::factory()->admin()->create();
    $country = Country::factory()->create(['code' => 'AA', 'name' => 'Alpha']);
    $city = City::factory()->for($country)->create(['code' => '01']);

    $this->actingAs($admin)
        ->delete(route('panel.tools.definitions.countries.destroy', $country))
        ->assertSessionHasErrors('definition');

    expect($country->refresh()->deleted_at)->toBeNull();

    District::factory()->for($city)->create();

    $this->actingAs($admin)
        ->delete(route('panel.tools.definitions.countries.cities.destroy', [$country, $city]))
        ->assertSessionHasErrors('definition');

    expect($city->refresh()->deleted_at)->toBeNull();
});

test('members cannot access panel definitions', function () {
    $member = User::factory()->member()->create();

    $this->actingAs($member)
        ->get(route('panel.tools.definitions.languages.index'))
        ->assertRedirect(route('dashboard'));
});

dataset('definition cases', [
    'language' => [[
        'model' => Language::class,
        'log_name' => 'language',
        'context' => fn () => [],
        'lookup' => fn () => ['code' => 'de'],
        'updated_field' => 'name',
        'updated_value' => 'Spanish',
        'store_route' => fn () => route('panel.tools.definitions.languages.store'),
        'update_route' => fn (array $context, Language $language) => route('panel.tools.definitions.languages.update', $language),
        'status_route' => fn (array $context, Language $language) => route('panel.tools.definitions.languages.status', $language),
        'destroy_route' => fn (array $context, Language $language) => route('panel.tools.definitions.languages.destroy', $language),
        'restore_route' => fn (array $context, Language $language) => route('panel.tools.definitions.languages.restore', $language),
        'force_delete_route' => fn (array $context, Language $language) => route('panel.tools.definitions.languages.force-delete', $language),
        'store_payload' => fn () => [
            'code' => 'de',
            'name' => 'German',
            'native_name' => 'Deutsch',
            'status' => Status::Active->value,
            'sort_order' => 3,
        ],
        'update_payload' => fn () => [
            'code' => 'es',
            'name' => 'Spanish',
            'native_name' => 'Español',
            'status' => Status::Active->value,
            'sort_order' => 4,
        ],
    ]],
    'currency' => [[
        'model' => Currency::class,
        'log_name' => 'currency',
        'context' => fn () => [],
        'lookup' => fn () => ['code' => 'EUR'],
        'updated_field' => 'name',
        'updated_value' => 'Euro Updated',
        'store_route' => fn () => route('panel.tools.definitions.currencies.store'),
        'update_route' => fn (array $context, Currency $currency) => route('panel.tools.definitions.currencies.update', $currency),
        'status_route' => fn (array $context, Currency $currency) => route('panel.tools.definitions.currencies.status', $currency),
        'destroy_route' => fn (array $context, Currency $currency) => route('panel.tools.definitions.currencies.destroy', $currency),
        'restore_route' => fn (array $context, Currency $currency) => route('panel.tools.definitions.currencies.restore', $currency),
        'force_delete_route' => fn (array $context, Currency $currency) => route('panel.tools.definitions.currencies.force-delete', $currency),
        'store_payload' => fn () => [
            'code' => 'EUR',
            'name' => 'Euro',
            'symbol' => 'EUR',
            'decimal_places' => 2,
            'status' => Status::Active->value,
            'sort_order' => 3,
        ],
        'update_payload' => fn (array $context, Currency $currency) => [
            'code' => $currency->code,
            'name' => 'Euro Updated',
            'symbol' => 'EUR',
            'decimal_places' => 2,
            'status' => Status::Active->value,
            'sort_order' => 3,
        ],
    ]],
    'country' => [[
        'model' => Country::class,
        'log_name' => 'country',
        'context' => fn () => [],
        'lookup' => fn () => ['code' => 'DE'],
        'updated_field' => 'name',
        'updated_value' => 'Germany Updated',
        'store_route' => fn () => route('panel.tools.definitions.countries.store'),
        'update_route' => fn (array $context, Country $country) => route('panel.tools.definitions.countries.update', $country),
        'status_route' => fn (array $context, Country $country) => route('panel.tools.definitions.countries.status', $country),
        'destroy_route' => fn (array $context, Country $country) => route('panel.tools.definitions.countries.destroy', $country),
        'restore_route' => fn (array $context, Country $country) => route('panel.tools.definitions.countries.restore', $country),
        'force_delete_route' => fn (array $context, Country $country) => route('panel.tools.definitions.countries.force-delete', $country),
        'store_payload' => fn () => [
            'code' => 'DE',
            'name' => 'Germany',
            'status' => Status::Active->value,
            'sort_order' => 3,
        ],
        'update_payload' => fn (array $context, Country $country) => [
            'code' => $country->code,
            'name' => 'Germany Updated',
            'status' => Status::Active->value,
            'sort_order' => 3,
        ],
    ]],
    'city' => [[
        'model' => City::class,
        'log_name' => 'city',
        'context' => fn () => ['country' => Country::factory()->create(['code' => 'BB', 'name' => 'Beta'])],
        'lookup' => fn (array $context) => ['country_id' => $context['country']->id, 'code' => '06'],
        'updated_field' => 'name',
        'updated_value' => 'Ankara Updated',
        'store_route' => fn (array $context) => route('panel.tools.definitions.countries.cities.store', $context['country']),
        'update_route' => fn (array $context, City $city) => route('panel.tools.definitions.countries.cities.update', [$context['country'], $city]),
        'status_route' => fn (array $context, City $city) => route('panel.tools.definitions.countries.cities.status', [$context['country'], $city]),
        'destroy_route' => fn (array $context, City $city) => route('panel.tools.definitions.countries.cities.destroy', [$context['country'], $city]),
        'restore_route' => fn (array $context, City $city) => route('panel.tools.definitions.countries.cities.restore', [$context['country'], $city]),
        'force_delete_route' => fn (array $context, City $city) => route('panel.tools.definitions.countries.cities.force-delete', [$context['country'], $city]),
        'store_payload' => fn () => [
            'code' => '06',
            'name' => 'Ankara',
            'status' => Status::Active->value,
            'sort_order' => 2,
        ],
        'update_payload' => fn () => [
            'code' => '06',
            'name' => 'Ankara Updated',
            'status' => Status::Active->value,
            'sort_order' => 2,
        ],
    ]],
    'district' => [[
        'model' => District::class,
        'log_name' => 'district',
        'context' => function () {
            $country = Country::factory()->create(['code' => 'CC', 'name' => 'Gamma']);
            $city = City::factory()->for($country)->create(['code' => '34', 'name' => 'Istanbul']);

            return ['country' => $country, 'city' => $city];
        },
        'lookup' => fn (array $context) => ['city_id' => $context['city']->id, 'name' => 'Çankaya'],
        'updated_field' => 'name',
        'updated_value' => 'Çankaya Updated',
        'store_route' => fn (array $context) => route('panel.tools.definitions.countries.cities.districts.store', [$context['country'], $context['city']]),
        'update_route' => fn (array $context, District $district) => route('panel.tools.definitions.countries.cities.districts.update', [$context['country'], $context['city'], $district]),
        'status_route' => fn (array $context, District $district) => route('panel.tools.definitions.countries.cities.districts.status', [$context['country'], $context['city'], $district]),
        'destroy_route' => fn (array $context, District $district) => route('panel.tools.definitions.countries.cities.districts.destroy', [$context['country'], $context['city'], $district]),
        'restore_route' => fn (array $context, District $district) => route('panel.tools.definitions.countries.cities.districts.restore', [$context['country'], $context['city'], $district]),
        'force_delete_route' => fn (array $context, District $district) => route('panel.tools.definitions.countries.cities.districts.force-delete', [$context['country'], $context['city'], $district]),
        'store_payload' => fn () => [
            'name' => 'Çankaya',
            'status' => Status::Active->value,
            'sort_order' => 2,
        ],
        'update_payload' => fn () => [
            'name' => 'Çankaya Updated',
            'status' => Status::Active->value,
            'sort_order' => 2,
        ],
    ]],
    'tax' => [[
        'model' => Tax::class,
        'log_name' => 'tax_rate',
        'context' => fn () => [],
        'lookup' => fn () => ['name' => 'KDV %1'],
        'updated_field' => 'name',
        'updated_value' => 'KDV %1 Updated',
        'store_route' => fn () => route('panel.tools.definitions.taxes.store'),
        'update_route' => fn (array $context, Tax $tax) => route('panel.tools.definitions.taxes.update', $tax),
        'status_route' => fn (array $context, Tax $tax) => route('panel.tools.definitions.taxes.status', $tax),
        'destroy_route' => fn (array $context, Tax $tax) => route('panel.tools.definitions.taxes.destroy', $tax),
        'restore_route' => fn (array $context, Tax $tax) => route('panel.tools.definitions.taxes.restore', $tax),
        'force_delete_route' => fn (array $context, Tax $tax) => route('panel.tools.definitions.taxes.force-delete', $tax),
        'store_payload' => fn () => [
            'name' => 'KDV %1',
            'rate' => 1,
            'status' => Status::Active->value,
        ],
        'update_payload' => fn () => [
            'name' => 'KDV %1 Updated',
            'rate' => 1,
            'status' => Status::Active->value,
        ],
    ]],
]);

dataset('default protected definition cases', [
    'language' => [[
        'model' => fn () => Language::query()->active()->firstOrFail(),
        'setting_key' => 'default_language_code',
        'setting_value' => fn (Language $language) => $language->code,
        'status_route' => fn (Language $language) => route('panel.tools.definitions.languages.status', $language),
        'destroy_route' => fn (Language $language) => route('panel.tools.definitions.languages.destroy', $language),
    ]],
    'currency' => [[
        'model' => fn () => Currency::query()->active()->firstOrFail(),
        'setting_key' => 'default_currency_id',
        'setting_value' => fn (Currency $currency) => $currency->id,
        'status_route' => fn (Currency $currency) => route('panel.tools.definitions.currencies.status', $currency),
        'destroy_route' => fn (Currency $currency) => route('panel.tools.definitions.currencies.destroy', $currency),
    ]],
    'country' => [[
        'model' => fn () => Country::query()->active()->doesntHave('cities')->first()
            ?? Country::factory()->create(['code' => 'DD', 'name' => 'Delta']),
        'setting_key' => 'default_country_id',
        'setting_value' => fn (Country $country) => $country->id,
        'status_route' => fn (Country $country) => route('panel.tools.definitions.countries.status', $country),
        'destroy_route' => fn (Country $country) => route('panel.tools.definitions.countries.destroy', $country),
    ]],
    'tax' => [[
        'model' => fn () => Tax::query()->active()->firstOrFail(),
        'setting_key' => 'default_tax_id',
        'setting_value' => fn (Tax $tax) => $tax->id,
        'status_route' => fn (Tax $tax) => route('panel.tools.definitions.taxes.status', $tax),
        'destroy_route' => fn (Tax $tax) => route('panel.tools.definitions.taxes.destroy', $tax),
    ]],
]);
