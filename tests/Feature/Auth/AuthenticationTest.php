<?php

declare(strict_types=1);

use App\Models\User;
use App\Notifications\Auth\NewDeviceLoginNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Features;

test('login screen can be rendered', function () {
    $response = $this->get(route('login'));

    $response->assertOk();
});

test('users can authenticate using the login screen', function () {
    $user = User::factory()->create();

    $response = $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    expect($user->refresh()->last_login_at)->not->toBeNull();

    $this->assertDatabaseHas('authentication_log', [
        'authenticatable_type' => User::class,
        'authenticatable_id' => $user->id,
        'ip_address' => '127.0.0.1',
    ]);
});

test('new device login creates auth notification and activity', function () {
    Notification::fake();

    $user = User::factory()->create([
        'created_at' => now()->subMinutes(5),
    ]);

    $this
        ->withHeader('User-Agent', 'Feature Test Browser')
        ->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])
        ->assertRedirect(route('dashboard', absolute: false));

    Notification::assertSentTo(
        $user,
        NewDeviceLoginNotification::class,
        fn (NewDeviceLoginNotification $notification): bool => $notification->ipAddress === '127.0.0.1'
            && $notification->userAgent === 'Feature Test Browser',
    );

    $this->assertDatabaseHas('activity_log', [
        'log_name' => 'auth',
        'event' => 'new_device_login',
        'subject_id' => $user->id,
        'causer_id' => $user->id,
    ]);
});

test('known device login does not create new device notification', function () {
    $user = User::factory()->create([
        'created_at' => now()->subMinutes(5),
    ]);

    $user->authentications()->create([
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Known Browser',
        'login_at' => now()->subDay(),
    ]);

    $this
        ->withHeader('User-Agent', 'Known Browser')
        ->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])
        ->assertRedirect(route('dashboard', absolute: false));

    expect($user->notifications()->count())->toBe(0);

    $this->assertDatabaseMissing('activity_log', [
        'log_name' => 'auth',
        'event' => 'new_device_login',
        'subject_id' => $user->id,
        'causer_id' => $user->id,
    ]);
});

test('users with two factor enabled are redirected to two factor challenge', function () {
    $this->skipUnlessFortifyHas(Features::twoFactorAuthentication());

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);

    $user = User::factory()->create();

    $user->forceFill([
        'two_factor_secret' => encrypt('test-secret'),
        'two_factor_recovery_codes' => encrypt(json_encode(['code1', 'code2'])),
        'two_factor_confirmed_at' => now(),
    ])->save();

    $response = $this->post(route('login'), [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertRedirect(route('two-factor.login'));
    $response->assertSessionHas('login.id', $user->id);
    $this->assertGuest();
});

test('users can not authenticate with invalid password', function () {
    $user = User::factory()->create();

    $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('logout'));

    $this->assertGuest();
    $response->assertRedirect(route('home'));
});

test('users are rate limited', function () {
    $user = User::factory()->create();

    RateLimiter::increment(md5('login'.implode('|', [$user->email, '127.0.0.1'])), amount: 5);

    $response = $this->post(route('login.store'), [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $response->assertTooManyRequests();
});
