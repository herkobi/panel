<?php

declare(strict_types=1);

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

test('confirm password screen can be rendered', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get(route('password.confirm'));

    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->component('auth/confirm-password'),
    );
});

test('password confirmation requires authentication', function () {
    $response = $this->get(route('password.confirm'));

    $response->assertRedirect(route('login'));
});

test('password confirmation error is localized', function () {
    app()->setLocale('tr');

    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('password.confirm.store'), [
            'password' => 'wrong-password',
        ])
        ->assertRedirect()
        ->assertSessionHasErrors([
            'password' => 'Girilen şifre hatalı.',
        ]);
});
