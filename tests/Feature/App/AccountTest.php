<?php

declare(strict_types=1);

use App\Models\Account;
use App\Models\City;
use App\Models\Country;
use App\Models\District;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('member can view account page', function () {
    $user = User::factory()->member()->create();

    $this->actingAs($user)
        ->get(route('app.account'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('app/account/index')
            ->has('countries')
            ->has('cities')
            ->has('districts'),
        );
});

test('member can update account information', function () {
    $user = User::factory()->member()->create();
    $district = District::query()->firstOrFail();
    $city = City::query()->findOrFail($district->city_id);
    $country = Country::query()->findOrFail($city->country_id);

    $this->actingAs($user)
        ->patch(route('app.account.update'), [
            'title' => 'Test Firma',
            'address' => 'Test adres',
            'postal_code' => '34000',
            'country_id' => $country->id,
            'city_id' => $city->id,
            'district_id' => $district->id,
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    $this->assertDatabaseHas('accounts', [
        'user_id' => $user->id,
        'title' => 'Test Firma',
        'country_id' => $country->id,
        'city_id' => $city->id,
        'district_id' => $district->id,
    ]);

    $this->assertDatabaseHas('activity_log', [
        'log_name' => 'account',
        'event' => 'updated',
    ]);
});

test('account update creates account when missing', function () {
    $user = User::factory()->member()->create();

    expect($user->account)->toBeNull();

    $this->actingAs($user)
        ->patch(route('app.account.update'), [
            'title' => 'Yeni Hesap',
            'address' => null,
            'postal_code' => null,
            'country_id' => null,
            'city_id' => null,
            'district_id' => null,
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect();

    expect(Account::query()->where('user_id', $user->id)->exists())->toBeTrue();
});

test('district must belong to selected city', function () {
    $user = User::factory()->member()->create();
    $country = Country::factory()->create(['code' => 'US']);
    $city = City::factory()->create(['country_id' => $country->id, 'code' => 'NY']);
    $otherCity = City::factory()->create(['country_id' => $country->id, 'code' => 'CA']);
    $district = District::factory()->create(['city_id' => $otherCity->id]);

    $this->actingAs($user)
        ->from(route('app.account'))
        ->patch(route('app.account.update'), [
            'title' => 'Test Firma',
            'address' => 'Test adres',
            'postal_code' => '34000',
            'country_id' => $country->id,
            'city_id' => $city->id,
            'district_id' => $district->id,
        ])
        ->assertSessionHasErrors('district_id')
        ->assertRedirect(route('app.account'));
});

test('admin cannot access app account page', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('app.account'))
        ->assertRedirect(route('dashboard'));
});
