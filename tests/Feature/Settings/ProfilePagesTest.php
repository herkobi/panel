<?php

declare(strict_types=1);

use App\Models\Activity;
use App\Models\User;
use App\Notifications\App\Profile\ProfileUpdatedNotification as AppProfileUpdatedNotification;
use App\Notifications\App\Profile\SessionRevokedNotification as AppSessionRevokedNotification;
use App\Notifications\Panel\Profile\ProfileUpdatedNotification as PanelProfileUpdatedNotification;
use App\Notifications\Panel\Profile\SessionRevokedNotification as PanelSessionRevokedNotification;
use Illuminate\Support\Facades\DB;
use Inertia\Testing\AssertableInertia as Assert;

test('app profile secondary pages are displayed', function (string $route, string $component) {
    $user = User::factory()->member()->create();

    $this->actingAs($user)
        ->get(route($route))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component($component));
})->with([
    ['app.profile.notifications', 'app/profile/notifications'],
    ['app.profile.sessions', 'app/profile/sessions'],
    ['app.profile.appearance.edit', 'app/profile/appearance'],
]);

test('panel profile secondary pages are displayed', function (string $route, string $component) {
    $user = User::factory()->admin()->create();

    $this->actingAs($user)
        ->get(route($route))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component($component));
})->with([
    ['panel.profile.notifications', 'panel/profile/notifications'],
    ['panel.profile.sessions', 'panel/profile/sessions'],
    ['panel.profile.appearance.edit', 'panel/profile/appearance'],
]);

test('app notifications page lists user notifications', function () {
    $user = User::factory()->member()->create();

    $user->notify(new AppProfileUpdatedNotification);

    $this->actingAs($user)
        ->get(route('app.profile.notifications'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('app/profile/notifications')
            ->has('notifications.data', 1)
            ->where('notifications.data.0.data.type', 'profile.updated')
        );
});

test('panel notifications page lists user notifications', function () {
    $user = User::factory()->admin()->create();

    $user->notify(new PanelProfileUpdatedNotification);

    $this->actingAs($user)
        ->get(route('panel.profile.notifications'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('panel/profile/notifications')
            ->has('notifications.data', 1)
            ->where('notifications.data.0.data.type', 'profile.updated')
        );
});

test('app sessions page lists active sessions by device', function () {
    $user = User::factory()->member()->create([
        'last_login_at' => now(),
    ]);
    $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0.0.0 Safari/537.36';

    $user->authentications()->create([
        'ip_address' => '127.0.0.1',
        'user_agent' => $userAgent,
        'login_at' => now(),
    ]);

    DB::table('sessions')->insert([
        [
            'id' => 'app-session-1',
            'user_id' => $user->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => $userAgent,
            'payload' => '',
            'last_activity' => now()->timestamp,
        ],
        [
            'id' => 'app-session-duplicate',
            'user_id' => $user->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => $userAgent,
            'payload' => '',
            'last_activity' => now()->subMinute()->timestamp,
        ],
        [
            'id' => 'app-session-expired',
            'user_id' => $user->id,
            'ip_address' => '127.0.0.2',
            'user_agent' => $userAgent,
            'payload' => '',
            'last_activity' => now()->subMinutes(300)->timestamp,
        ],
    ]);

    $this->actingAs($user)
        ->get(route('app.profile.sessions'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('app/profile/sessions')
            ->where('last_login_at', fn ($value) => $value !== null)
            ->has('sessions.data', 1)
            ->where('sessions.data.0.ip_address', '127.0.0.1')
            ->where('sessions.data.0.browser', 'Google Chrome')
            ->where('sessions.data.0.session_count', 2)
        );
});

test('panel sessions page lists active sessions by device', function () {
    $user = User::factory()->admin()->create([
        'last_login_at' => now(),
    ]);
    $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 Version/17.0 Safari/605.1.15';

    $user->authentications()->create([
        'ip_address' => '127.0.0.1',
        'user_agent' => $userAgent,
        'login_at' => now(),
    ]);

    DB::table('sessions')->insert([
        'id' => 'panel-session-1',
        'user_id' => $user->id,
        'ip_address' => '127.0.0.1',
        'user_agent' => $userAgent,
        'payload' => '',
        'last_activity' => now()->timestamp,
    ]);

    $this->actingAs($user)
        ->get(route('panel.profile.sessions'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('panel/profile/sessions')
            ->where('last_login_at', fn ($value) => $value !== null)
            ->has('sessions.data', 1)
            ->where('sessions.data.0.ip_address', '127.0.0.1')
            ->where('sessions.data.0.browser', 'Safari')
            ->where('sessions.data.0.session_count', 1)
        );
});

test('app user can revoke another active session', function () {
    $user = User::factory()->member()->create();
    $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0.0.0 Safari/537.36';

    $authentication = $user->authentications()->create([
        'ip_address' => '127.0.0.1',
        'user_agent' => $userAgent,
        'login_at' => now(),
    ]);

    DB::table('sessions')->insert([
        [
            'id' => 'app-session-target',
            'user_id' => $user->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => $userAgent,
            'payload' => '',
            'last_activity' => now()->timestamp,
        ],
        [
            'id' => 'app-session-target-duplicate',
            'user_id' => $user->id,
            'ip_address' => '127.0.0.1',
            'user_agent' => $userAgent,
            'payload' => '',
            'last_activity' => now()->subMinute()->timestamp,
        ],
    ]);

    $this->actingAs($user)
        ->delete(route('app.profile.sessions.destroy', 'app-session-target'))
        ->assertRedirect()
        ->assertSessionHas('toast.type', 'success');

    $this->assertDatabaseMissing('sessions', ['id' => 'app-session-target']);
    $this->assertDatabaseMissing('sessions', ['id' => 'app-session-target-duplicate']);
    expect($authentication->refresh()->logout_at)->not->toBeNull();

    $notification = $user->notifications()->first();

    expect($notification?->type)->toBe(AppSessionRevokedNotification::class);
    expect($notification?->data)->toMatchArray([
        'type' => 'profile.session_revoked',
        'title' => __('Oturum kapatıldı.'),
    ]);
    expect(
        Activity::query()
            ->where('log_name', 'profile')
            ->where('event', 'session_revoked')
            ->where('subject_id', $user->getKey())
            ->where('causer_id', $user->getKey())
            ->exists()
    )->toBeTrue();
});

test('panel user can revoke another active session', function () {
    $user = User::factory()->admin()->create();
    $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 Version/17.0 Safari/605.1.15';

    DB::table('sessions')->insert([
        'id' => 'panel-session-target',
        'user_id' => $user->id,
        'ip_address' => '127.0.0.1',
        'user_agent' => $userAgent,
        'payload' => '',
        'last_activity' => now()->timestamp,
    ]);

    $this->actingAs($user)
        ->delete(route('panel.profile.sessions.destroy', 'panel-session-target'))
        ->assertRedirect()
        ->assertSessionHas('toast.type', 'success');

    $this->assertDatabaseMissing('sessions', ['id' => 'panel-session-target']);

    $notification = $user->notifications()->first();

    expect($notification?->type)->toBe(PanelSessionRevokedNotification::class);
    expect($notification?->data)->toMatchArray([
        'type' => 'profile.session_revoked',
        'title' => __('Oturum kapatıldı.'),
    ]);
    expect(
        Activity::query()
            ->where('log_name', 'profile')
            ->where('event', 'session_revoked')
            ->where('subject_id', $user->getKey())
            ->where('causer_id', $user->getKey())
            ->exists()
    )->toBeTrue();
});

test('user cannot revoke another users active session', function () {
    $user = User::factory()->member()->create();
    $otherUser = User::factory()->member()->create();

    DB::table('sessions')->insert([
        'id' => 'other-user-session',
        'user_id' => $otherUser->id,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Mozilla/5.0',
        'payload' => '',
        'last_activity' => now()->timestamp,
    ]);

    $this->actingAs($user)
        ->delete(route('app.profile.sessions.destroy', 'other-user-session'))
        ->assertNotFound();

    $this->assertDatabaseHas('sessions', ['id' => 'other-user-session']);
});

test('app user can mark own notification as read', function () {
    $user = User::factory()->member()->create();

    $user->notify(new AppProfileUpdatedNotification);
    $notification = $user->notifications()->firstOrFail();

    $this->actingAs($user)
        ->patch(route('app.profile.notifications.read', $notification))
        ->assertRedirect();

    expect($notification->refresh()->read_at)->not->toBeNull();
});

test('panel user can mark own notification as read', function () {
    $user = User::factory()->admin()->create();

    $user->notify(new PanelProfileUpdatedNotification);
    $notification = $user->notifications()->firstOrFail();

    $this->actingAs($user)
        ->patch(route('panel.profile.notifications.read', $notification))
        ->assertRedirect();

    expect($notification->refresh()->read_at)->not->toBeNull();
});

test('user cannot mark another user notification as read', function () {
    $user = User::factory()->member()->create();
    $otherUser = User::factory()->member()->create();

    $otherUser->notify(new AppProfileUpdatedNotification);
    $notification = $otherUser->notifications()->firstOrFail();

    $this->actingAs($user)
        ->patch(route('app.profile.notifications.read', $notification))
        ->assertNotFound();

    expect($notification->refresh()->read_at)->toBeNull();
});
