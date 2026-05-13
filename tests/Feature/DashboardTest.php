<?php

declare(strict_types=1);

use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));

    $response->assertRedirect(route('login'));
});

test('admin users are redirected to the panel dashboard', function () {
    $user = User::factory()->admin()->create();

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertRedirect(route('panel.dashboard'));
});

test('member users are redirected to the app dashboard', function () {
    $user = User::factory()->member()->create();

    $response = $this->actingAs($user)->get(route('dashboard'));

    $response->assertRedirect(route('app.dashboard'));
});
