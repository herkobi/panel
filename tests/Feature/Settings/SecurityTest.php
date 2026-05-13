<?php

declare(strict_types=1);

use App\Models\Activity;
use App\Models\User;
use App\Notifications\App\Profile\PasswordUpdatedNotification as AppPasswordUpdatedNotification;
use App\Notifications\App\Profile\TwoFactorAuthenticationUpdatedNotification as AppTwoFactorAuthenticationUpdatedNotification;
use App\Notifications\Panel\Profile\PasswordUpdatedNotification as PanelPasswordUpdatedNotification;
use App\Notifications\Panel\Profile\TwoFactorAuthenticationUpdatedNotification as PanelTwoFactorAuthenticationUpdatedNotification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;
use Laravel\Fortify\Features;
use Laravel\Fortify\TwoFactorAuthenticationProvider;
use PragmaRX\Google2FA\Google2FA;

test('app security page is displayed', function () {
    $this->skipUnlessFortifyHas(Features::twoFactorAuthentication());

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);

    $user = User::factory()->member()->create();

    $this->actingAs($user)
        ->withSession(['auth.password_confirmed_at' => time()])
        ->get(route('app.profile.security'))
        ->assertInertia(fn (Assert $page) => $page
            ->component('app/profile/security')
            ->where('canManageTwoFactor', true)
            ->where('twoFactorEnabled', false),
        );
});

test('panel security page is displayed', function () {
    $this->skipUnlessFortifyHas(Features::twoFactorAuthentication());

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);

    $user = User::factory()->admin()->create();

    $this->actingAs($user)
        ->withSession(['auth.password_confirmed_at' => time()])
        ->get(route('panel.profile.security'))
        ->assertInertia(fn (Assert $page) => $page
            ->component('panel/profile/security')
            ->where('canManageTwoFactor', true)
            ->where('twoFactorEnabled', false),
        );
});

test('security page requires password confirmation when enabled', function () {
    $this->skipUnlessFortifyHas(Features::twoFactorAuthentication());

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);

    $user = User::factory()->member()->create();

    $response = $this->actingAs($user)
        ->get(route('app.profile.security'));

    $response->assertRedirect(route('password.confirm'));
});

test('two factor confirmation error is localized', function () {
    app()->setLocale('tr');

    $this->skipUnlessFortifyHas(Features::twoFactorAuthentication());

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);

    $user = User::factory()->member()->create();
    $secret = app(TwoFactorAuthenticationProvider::class)->generateSecretKey();

    $user->forceFill([
        'two_factor_secret' => encrypt($secret),
        'two_factor_recovery_codes' => encrypt(json_encode(['code1', 'code2'])),
    ])->save();

    $this->actingAs($user)
        ->withSession(['auth.password_confirmed_at' => time()])
        ->post(route('two-factor.confirm'), [
            'code' => '000000',
        ])
        ->assertRedirect()
        ->assertSessionHasErrors([
            'code' => 'Girilen iki aşamalı doğrulama kodu hatalı.',
        ], null, 'confirmTwoFactorAuthentication');
});

test('app two factor confirmation creates activity and notification', function () {
    $this->skipUnlessFortifyHas(Features::twoFactorAuthentication());

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);

    $user = User::factory()->member()->create();
    $secret = app(TwoFactorAuthenticationProvider::class)->generateSecretKey();
    $code = app(Google2FA::class)->getCurrentOtp($secret);

    $user->forceFill([
        'two_factor_secret' => encrypt($secret),
        'two_factor_recovery_codes' => encrypt(json_encode(['code1', 'code2'])),
    ])->save();

    $this->actingAs($user)
        ->withSession(['auth.password_confirmed_at' => time()])
        ->post(route('two-factor.confirm'), [
            'code' => $code,
        ])
        ->assertRedirect();

    expect($user->refresh()->two_factor_confirmed_at)->not->toBeNull();

    $notification = $user->notifications()->first();

    expect($notification?->type)->toBe(AppTwoFactorAuthenticationUpdatedNotification::class);
    expect($notification?->data)->toMatchArray([
        'type' => 'profile.two_factor_enabled',
        'title' => __('İki aşamalı doğrulama açıldı.'),
    ]);
    expect(
        Activity::query()
            ->where('log_name', 'profile')
            ->where('event', 'two_factor_enabled')
            ->where('subject_id', $user->getKey())
            ->where('causer_id', $user->getKey())
            ->exists()
    )->toBeTrue();
});

test('panel two factor disable creates activity and notification', function () {
    $this->skipUnlessFortifyHas(Features::twoFactorAuthentication());

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);

    $user = User::factory()->admin()->create();

    $user->forceFill([
        'two_factor_secret' => encrypt(app(TwoFactorAuthenticationProvider::class)->generateSecretKey()),
        'two_factor_recovery_codes' => encrypt(json_encode(['code1', 'code2'])),
        'two_factor_confirmed_at' => now(),
    ])->save();

    $this->actingAs($user)
        ->withSession(['auth.password_confirmed_at' => time()])
        ->delete(route('two-factor.disable'))
        ->assertRedirect();

    $user->refresh();

    expect($user->two_factor_secret)->toBeNull();
    expect($user->two_factor_confirmed_at)->toBeNull();

    $notification = $user->notifications()->first();

    expect($notification?->type)->toBe(PanelTwoFactorAuthenticationUpdatedNotification::class);
    expect($notification?->data)->toMatchArray([
        'type' => 'profile.two_factor_disabled',
        'title' => __('İki aşamalı doğrulama kapatıldı.'),
    ]);
    expect(
        Activity::query()
            ->where('log_name', 'profile')
            ->where('event', 'two_factor_disabled')
            ->where('subject_id', $user->getKey())
            ->where('causer_id', $user->getKey())
            ->exists()
    )->toBeTrue();
});

test('app password can be updated', function () {
    config(['session.driver' => 'database']);

    $user = User::factory()->member()->create();

    DB::table('sessions')->insert([
        'id' => 'app-password-session',
        'user_id' => $user->id,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Mozilla/5.0',
        'payload' => '',
        'last_activity' => now()->timestamp,
    ]);

    $response = $this
        ->actingAs($user)
        ->from(route('app.profile.security'))
        ->put(route('app.profile.password.update'), [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('login'))
        ->assertSessionHas('toast.type', 'success');

    expect(Hash::check('new-password', $user->refresh()->password))->toBeTrue();
    $this->assertGuest();
    $this->assertDatabaseMissing('sessions', ['id' => 'app-password-session']);

    $notification = $user->notifications()->first();

    expect($notification?->type)->toBe(AppPasswordUpdatedNotification::class);
    expect($notification?->data)->toMatchArray([
        'type' => 'profile.password_updated',
        'title' => __('Şifreniz güncellendi.'),
    ]);
    expect(
        Activity::query()
            ->where('log_name', 'profile')
            ->where('event', 'password_updated')
            ->where('subject_id', $user->getKey())
            ->where('causer_id', $user->getKey())
            ->exists()
    )->toBeTrue();
});

test('panel password can be updated', function () {
    config(['session.driver' => 'database']);

    $user = User::factory()->admin()->create();

    DB::table('sessions')->insert([
        'id' => 'panel-password-session',
        'user_id' => $user->id,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Mozilla/5.0',
        'payload' => '',
        'last_activity' => now()->timestamp,
    ]);

    $response = $this
        ->actingAs($user)
        ->from(route('panel.profile.security'))
        ->put(route('panel.profile.password.update'), [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('login'))
        ->assertSessionHas('toast.type', 'success');

    expect(Hash::check('new-password', $user->refresh()->password))->toBeTrue();
    $this->assertGuest();
    $this->assertDatabaseMissing('sessions', ['id' => 'panel-password-session']);

    $notification = $user->notifications()->first();

    expect($notification?->type)->toBe(PanelPasswordUpdatedNotification::class);
    expect($notification?->data)->toMatchArray([
        'type' => 'profile.password_updated',
        'title' => __('Şifreniz güncellendi.'),
    ]);
    expect(
        Activity::query()
            ->where('log_name', 'profile')
            ->where('event', 'password_updated')
            ->where('subject_id', $user->getKey())
            ->where('causer_id', $user->getKey())
            ->exists()
    )->toBeTrue();
});

test('correct password must be provided to update password', function () {
    $user = User::factory()->member()->create();

    $response = $this
        ->actingAs($user)
        ->from(route('app.profile.security'))
        ->put(route('app.profile.password.update'), [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasErrors('current_password')
        ->assertRedirect(route('app.profile.security'));
});
