<?php

declare(strict_types=1);

use App\Enums\UserStatus;
use App\Mail\Panel\Settings\User\UserEmailChangeRequestedMail;
use App\Mail\Panel\Settings\User\UserEmailVerifiedMail;
use App\Mail\Panel\Settings\User\UserStatusUpdatedMail;
use App\Mail\Panel\Settings\User\UserWelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Inertia\Testing\AssertableInertia as Assert;

test('panel users page lists only admin users', function () {
    $viewer = User::factory()->superAdmin()->create();
    $admin = User::factory()->admin()->create([
        'name' => 'Needle Admin',
    ]);
    User::factory()->member()->create([
        'name' => 'Needle Member',
    ]);

    $this->actingAs($viewer)
        ->get(route('panel.settings.users.index', ['q' => 'Needle']))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('panel/settings/users/index')
            ->has('users.data', 1)
            ->where('users.data.0.id', $admin->id)
            ->where('users.data.0.user_type', 'admin')
        );
});

test('panel user detail includes activity and session logs', function () {
    $viewer = User::factory()->superAdmin()->create();
    $admin = User::factory()->admin()->create();
    $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0.0.0 Safari/537.36';

    activity('profile')
        ->causedBy($admin)
        ->performedOn($admin)
        ->event('updated')
        ->log('Profile updated');

    $admin->authentications()->create([
        'ip_address' => '127.0.0.1',
        'user_agent' => $userAgent,
        'login_at' => now(),
    ]);

    $this->actingAs($viewer)
        ->get(route('panel.settings.users.show', $admin))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('panel/settings/users/show')
            ->where('user.data.id', $admin->id)
            ->has('activities.data', 1)
            ->where('activities.data.0.event', 'updated')
            ->has('sessions.data', 1)
            ->where('sessions.data.0.ip_address', '127.0.0.1')
            ->where('sessions.data.0.browser', 'Google Chrome')
        );
});

test('panel user detail rejects member users', function () {
    $viewer = User::factory()->superAdmin()->create();
    $member = User::factory()->member()->create();

    $this->actingAs($viewer)
        ->get(route('panel.settings.users.show', $member))
        ->assertNotFound();
});

test('panel admin can create a panel user and send welcome mail', function () {
    Mail::fake();

    $viewer = User::factory()->superAdmin()->create();

    $this->actingAs($viewer)
        ->post(route('panel.settings.users.store'), [
            'name' => 'Created Panel User',
            'email' => 'created-panel-user@example.com',
            'status' => UserStatus::Active->value,
            'role' => 'Admin',
            'email_verified' => true,
        ])
        ->assertRedirect();

    $created = User::query()
        ->where('email', 'created-panel-user@example.com')
        ->firstOrFail();

    expect($created->name)->toBe('Created Panel User')
        ->and($created->user_type->isAdmin())->toBeTrue()
        ->and($created->status)->toBe(UserStatus::Active)
        ->and($created->email_verified_at)->not->toBeNull();

    Mail::assertSent(
        UserWelcomeMail::class,
        fn (UserWelcomeMail $mail): bool => $mail->hasTo($created->email)
            && $mail->verifiesEmail === false
            && str_contains($mail->welcomeUrl, 'token='),
    );

    $this->assertDatabaseHas('activity_log', [
        'subject_id' => $created->id,
        'causer_id' => $viewer->id,
        'event' => 'created',
    ]);
});

test('panel user welcome link verifies email before password reset when needed', function () {
    Mail::fake();

    $viewer = User::factory()->superAdmin()->create();

    $this->actingAs($viewer)
        ->post(route('panel.settings.users.store'), [
            'name' => 'Unverified Panel User',
            'email' => 'unverified-panel-user@example.com',
            'status' => UserStatus::Active->value,
            'role' => 'Admin',
            'email_verified' => false,
        ])
        ->assertRedirect();

    $created = User::query()
        ->where('email', 'unverified-panel-user@example.com')
        ->firstOrFail();

    expect($created->email_verified_at)->toBeNull();

    $welcomeUrl = null;

    Mail::assertSent(
        UserWelcomeMail::class,
        function (UserWelcomeMail $mail) use (&$welcomeUrl, $created): bool {
            $welcomeUrl = $mail->welcomeUrl;

            return $mail->hasTo($created->email)
                && $mail->verifiesEmail === true;
        },
    );

    expect($welcomeUrl)->toBeString();

    $response = $this->get($welcomeUrl);

    $response->assertRedirect();

    expect($response->headers->get('Location'))->toContain('/reset-password/');

    expect($created->fresh()->email_verified_at)->not->toBeNull();

    $this->assertDatabaseHas('activity_log', [
        'subject_id' => $created->id,
        'causer_id' => $created->id,
        'event' => 'welcome_accepted',
    ]);
});

test('panel admin can verify a panel user email address', function () {
    Mail::fake();

    $viewer = User::factory()->superAdmin()->create();
    $admin = User::factory()->admin()->unverified()->create();

    $this->actingAs($viewer)
        ->post(route('panel.settings.users.email.verify', $admin))
        ->assertRedirect();

    expect($admin->fresh()->email_verified_at)->not->toBeNull();

    Mail::assertSent(
        UserEmailVerifiedMail::class,
        fn (UserEmailVerifiedMail $mail): bool => $mail->hasTo($admin->email),
    );

    $this->assertDatabaseHas('activity_log', [
        'subject_id' => $admin->id,
        'causer_id' => $viewer->id,
        'event' => 'email_verified',
    ]);
});

test('panel admin can request a panel user email change and close sessions', function () {
    config(['session.driver' => 'database']);
    Mail::fake();

    $viewer = User::factory()->superAdmin()->create();
    $admin = User::factory()->admin()->create();
    $newEmail = 'new-panel-admin@example.com';

    DB::table('sessions')->insert([
        'id' => 'session-id',
        'user_id' => $admin->id,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Feature Test',
        'payload' => 'payload',
        'last_activity' => now()->getTimestamp(),
    ]);

    $authentication = $admin->authentications()->create([
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Feature Test',
        'login_at' => now(),
    ]);

    $this->actingAs($viewer)
        ->post(route('panel.settings.users.email.change', $admin), [
            'email' => $newEmail,
        ])
        ->assertRedirect();

    $this->assertDatabaseMissing('sessions', [
        'id' => 'session-id',
    ]);

    expect($authentication->fresh()->logout_at)->not->toBeNull();

    Mail::assertSent(
        UserEmailChangeRequestedMail::class,
        fn (UserEmailChangeRequestedMail $mail): bool => $mail->hasTo($newEmail)
            && $mail->email === $newEmail
            && str_contains($mail->confirmationUrl, 'email='),
    );

    $this->assertDatabaseHas('activity_log', [
        'subject_id' => $admin->id,
        'causer_id' => $viewer->id,
        'event' => 'email_change_requested',
    ]);
});

test('panel user email change can be confirmed with a signed link', function () {
    config(['session.driver' => 'database']);

    $admin = User::factory()->admin()->create([
        'email' => 'old-panel-admin@example.com',
    ]);
    $newEmail = 'confirmed-panel-admin@example.com';

    DB::table('sessions')->insert([
        'id' => 'session-id',
        'user_id' => $admin->id,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Feature Test',
        'payload' => 'payload',
        'last_activity' => now()->getTimestamp(),
    ]);

    $authentication = $admin->authentications()->create([
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Feature Test',
        'login_at' => now(),
    ]);

    $url = URL::temporarySignedRoute(
        'panel.settings.users.email.confirm',
        now()->addDay(),
        [
            'user' => $admin->id,
            'email' => $newEmail,
        ],
    );

    $this->get($url)->assertRedirect(route('login'));

    $admin->refresh();

    expect($admin->email)->toBe($newEmail)
        ->and($admin->email_verified_at)->not->toBeNull()
        ->and($authentication->fresh()->logout_at)->not->toBeNull();

    $this->assertDatabaseMissing('sessions', [
        'id' => 'session-id',
    ]);

    $this->assertDatabaseHas('activity_log', [
        'subject_id' => $admin->id,
        'causer_id' => $admin->id,
        'event' => 'email_changed',
    ]);
});

test('panel admin can update a panel user status', function () {
    Mail::fake();

    $viewer = User::factory()->superAdmin()->create();
    $admin = User::factory()->admin()->create();

    $this->actingAs($viewer)
        ->patch(route('panel.settings.users.status', $admin), [
            'status' => UserStatus::Passive->value,
        ])
        ->assertRedirect();

    expect($admin->fresh()->status)->toBe(UserStatus::Passive);

    Mail::assertSent(
        UserStatusUpdatedMail::class,
        fn (UserStatusUpdatedMail $mail): bool => $mail->hasTo($admin->email)
            && $mail->status === UserStatus::Passive,
    );

    $this->assertDatabaseHas('activity_log', [
        'subject_id' => $admin->id,
        'causer_id' => $viewer->id,
        'event' => 'status_updated',
    ]);
});
