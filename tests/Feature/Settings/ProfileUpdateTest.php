<?php

declare(strict_types=1);

use App\Enums\Status;
use App\Models\Activity;
use App\Models\Language;
use App\Models\User;
use App\Notifications\App\Profile\PreferencesUpdatedNotification as AppPreferencesUpdatedNotification;
use App\Notifications\App\Profile\ProfileUpdatedNotification as AppProfileUpdatedNotification;
use App\Notifications\Auth\VerifyEmailNotification;
use App\Notifications\Panel\Profile\PreferencesUpdatedNotification as PanelPreferencesUpdatedNotification;
use App\Notifications\Panel\Profile\ProfileUpdatedNotification as PanelProfileUpdatedNotification;
use Illuminate\Support\Facades\Notification;

test('app profile page is displayed', function () {
    $user = User::factory()->member()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('app.profile.edit'));

    $response->assertOk();
});

test('panel profile page is displayed', function () {
    $user = User::factory()->admin()->create();

    $response = $this
        ->actingAs($user)
        ->get(route('panel.profile.edit'));

    $response->assertOk();
});

test('app profile information can be updated', function () {
    $user = User::factory()->member()->create();

    $response = $this
        ->actingAs($user)
        ->patch(route('app.profile.update'), [
            'name' => 'Test User',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('app.profile.edit'))
        ->assertSessionHas('toast.type', 'success')
        ->assertSessionHas('toast.message', __('Profil güncellendi.'));

    $user->refresh();

    expect($user->name)->toBe('Test User');
    expect($user->email)->not->toBe('test@example.com');
    expect($user->email_verified_at)->not->toBeNull();

    $notification = $user->notifications()->first();

    expect($notification)->not->toBeNull();
    expect($notification?->type)->toBe(AppProfileUpdatedNotification::class);
    expect($notification?->data)->toMatchArray([
        'type' => 'profile.updated',
        'title' => __('Profil bilgileriniz güncellendi.'),
    ]);
    expect(
        Activity::query()
            ->where('log_name', 'profile')
            ->where('event', 'updated')
            ->where('subject_id', $user->getKey())
            ->where('causer_id', $user->getKey())
            ->exists()
    )->toBeTrue();
});

test('panel profile information can be updated', function () {
    $user = User::factory()->admin()->create();

    $response = $this
        ->actingAs($user)
        ->patch(route('panel.profile.update'), [
            'name' => 'Panel User',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('panel.profile.edit'))
        ->assertSessionHas('toast.type', 'success')
        ->assertSessionHas('toast.message', __('Profil güncellendi.'));

    $user->refresh();

    expect($user->name)->toBe('Panel User');
    expect($user->email)->not->toBe('panel@example.com');
    expect($user->email_verified_at)->not->toBeNull();

    $notification = $user->notifications()->first();

    expect($notification)->not->toBeNull();
    expect($notification?->type)->toBe(PanelProfileUpdatedNotification::class);
    expect($notification?->data)->toMatchArray([
        'type' => 'profile.updated',
        'title' => __('Profil bilgileriniz güncellendi.'),
    ]);
    expect(
        Activity::query()
            ->where('log_name', 'profile')
            ->where('event', 'updated')
            ->where('subject_id', $user->getKey())
            ->where('causer_id', $user->getKey())
            ->exists()
    )->toBeTrue();
});

test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->member()->create();

    $response = $this
        ->actingAs($user)
        ->patch(route('app.profile.update'), [
            'name' => 'Test User',
            'email' => $user->email,
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('app.profile.edit'));

    expect($user->refresh()->email_verified_at)->not->toBeNull();
});

test('app email address can be updated from the separate email endpoint', function () {
    Notification::fake();

    $user = User::factory()->member()->create();

    $response = $this
        ->actingAs($user)
        ->put(route('app.profile.email.update'), [
            'email' => 'new-app-email@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('login'));

    $user->refresh();

    expect($user->email)->toBe('new-app-email@example.com');
    expect($user->email_verified_at)->toBeNull();

    Notification::assertSentTo($user, VerifyEmailNotification::class);
    Notification::assertSentTo(
        $user,
        AppProfileUpdatedNotification::class,
        fn (AppProfileUpdatedNotification $notification): bool => $notification->emailChanged()
    );
    expect(
        Activity::query()
            ->where('log_name', 'profile')
            ->where('event', 'email_updated')
            ->where('subject_id', $user->getKey())
            ->where('causer_id', $user->getKey())
            ->exists()
    )->toBeTrue();
    $this->assertGuest();
});

test('panel email address can be updated from the separate email endpoint', function () {
    Notification::fake();

    $user = User::factory()->admin()->create();

    $response = $this
        ->actingAs($user)
        ->put(route('panel.profile.email.update'), [
            'email' => 'new-panel-email@example.com',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('login'));

    $user->refresh();

    expect($user->email)->toBe('new-panel-email@example.com');
    expect($user->email_verified_at)->toBeNull();

    Notification::assertSentTo($user, VerifyEmailNotification::class);
    Notification::assertSentTo(
        $user,
        PanelProfileUpdatedNotification::class,
        fn (PanelProfileUpdatedNotification $notification): bool => $notification->emailChanged()
    );
    expect(
        Activity::query()
            ->where('log_name', 'profile')
            ->where('event', 'email_updated')
            ->where('subject_id', $user->getKey())
            ->where('causer_id', $user->getKey())
            ->exists()
    )->toBeTrue();
    $this->assertGuest();
});

test('app preferences can be updated', function () {
    Language::query()->updateOrCreate(['code' => 'en'], [
        'code' => 'en',
        'name' => 'English',
        'native_name' => 'English',
        'status' => Status::Active,
    ]);

    $user = User::factory()->member()->create([
        'locale' => 'tr',
        'timezone' => 'Europe/Istanbul',
    ]);

    $response = $this
        ->actingAs($user)
        ->put(route('app.profile.appearance.update'), [
            'locale' => 'en',
            'timezone' => 'UTC',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('app.profile.appearance.edit'))
        ->assertSessionHas('toast.type', 'success')
        ->assertSessionHas('toast.message', __('Tercihler güncellendi.'))
        ->assertSessionHas('locale', 'en')
        ->assertSessionHas('timezone', 'UTC');

    expect($user->refresh()->locale)->toBe('en');
    expect($user->timezone)->toBe('UTC');

    $notification = $user->notifications()->first();

    expect($notification)->not->toBeNull();
    expect($notification?->type)->toBe(AppPreferencesUpdatedNotification::class);
    expect($notification?->data)->toMatchArray([
        'type' => 'profile.preferences_updated',
        'title' => __('Tercihleriniz güncellendi.'),
    ]);
    expect(
        Activity::query()
            ->where('log_name', 'profile')
            ->where('event', 'preferences_updated')
            ->where('subject_id', $user->getKey())
            ->where('causer_id', $user->getKey())
            ->exists()
    )->toBeTrue();
});

test('panel preferences can be updated', function () {
    Language::query()->updateOrCreate(['code' => 'en'], [
        'code' => 'en',
        'name' => 'English',
        'native_name' => 'English',
        'status' => Status::Active,
    ]);

    $user = User::factory()->admin()->create([
        'locale' => 'tr',
        'timezone' => 'Europe/Istanbul',
    ]);

    $response = $this
        ->actingAs($user)
        ->put(route('panel.profile.appearance.update'), [
            'locale' => 'en',
            'timezone' => 'UTC',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('panel.profile.appearance.edit'))
        ->assertSessionHas('toast.type', 'success')
        ->assertSessionHas('toast.message', __('Tercihler güncellendi.'))
        ->assertSessionHas('locale', 'en')
        ->assertSessionHas('timezone', 'UTC');

    expect($user->refresh()->locale)->toBe('en');
    expect($user->timezone)->toBe('UTC');

    $notification = $user->notifications()->first();

    expect($notification)->not->toBeNull();
    expect($notification?->type)->toBe(PanelPreferencesUpdatedNotification::class);
    expect($notification?->data)->toMatchArray([
        'type' => 'profile.preferences_updated',
        'title' => __('Tercihleriniz güncellendi.'),
    ]);
    expect(
        Activity::query()
            ->where('log_name', 'profile')
            ->where('event', 'preferences_updated')
            ->where('subject_id', $user->getKey())
            ->where('causer_id', $user->getKey())
            ->exists()
    )->toBeTrue();
});
