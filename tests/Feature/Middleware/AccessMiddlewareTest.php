<?php

declare(strict_types=1);

use App\Enums\Status;
use App\Models\Language;
use App\Models\User;

test('admin middleware blocks member users from panel routes', function () {
    $member = User::factory()->member()->create();

    $this->actingAs($member)
        ->get(route('panel.dashboard'))
        ->assertRedirect(route('dashboard'));
});

test('member middleware blocks admin users from app routes', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('app.dashboard'))
        ->assertRedirect(route('dashboard'));
});

test('passive users are logged out and redirected to login', function () {
    $user = User::factory()->member()->passive()->create();

    $this->actingAs($user)
        ->get(route('app.dashboard'))
        ->assertRedirect(route('login'));

    $this->assertGuest();
});

test('draft users can read but cannot write', function () {
    $user = User::factory()->admin()->draft()->create();

    $this->actingAs($user)
        ->get(route('panel.dashboard'))
        ->assertOk();

    $this->actingAs($user)
        ->from(route('panel.tools.definitions.languages.index'))
        ->post(route('panel.tools.definitions.languages.store'), [
            'code' => 'it',
            'name' => 'Italian',
            'native_name' => 'Italiano',
            'status' => Status::Active->value,
            'sort_order' => 10,
        ])
        ->assertRedirect(route('panel.tools.definitions.languages.index'))
        ->assertSessionHas('error');

    expect(Language::query()->where('code', 'it')->exists())->toBeFalse();
});
