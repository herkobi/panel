<?php

declare(strict_types=1);

use App\Enums\UserStatus;
use App\Mail\Panel\Members\MemberEmailChangeRequestedMail;
use App\Mail\Panel\Members\MemberEmailVerifiedMail;
use App\Mail\Panel\Members\MemberStatusUpdatedMail;
use App\Mail\Panel\Members\MemberWelcomeMail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Inertia\Testing\AssertableInertia as Assert;

test('panel members page lists only member users', function () {
    $viewer = User::factory()->admin()->create();
    $member = User::factory()->member()->create([
        'name' => 'Needle Member',
    ]);
    User::factory()->admin()->create([
        'name' => 'Needle Admin',
    ]);

    $this->actingAs($viewer)
        ->get(route('panel.members.index', ['q' => 'Needle']))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('panel/members/index')
            ->has('users.data', 1)
            ->where('users.data.0.id', $member->id)
            ->where('users.data.0.user_type', 'member')
        );
});

test('panel member detail includes activity and session logs', function () {
    $viewer = User::factory()->admin()->create();
    $member = User::factory()->member()->create();
    $userAgent = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/120.0.0.0 Safari/537.36';

    activity('profile')
        ->causedBy($member)
        ->performedOn($member)
        ->event('updated')
        ->log('Profile updated');

    $member->authentications()->create([
        'ip_address' => '127.0.0.1',
        'user_agent' => $userAgent,
        'login_at' => now(),
    ]);

    $this->actingAs($viewer)
        ->get(route('panel.members.show', $member))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('panel/members/show')
            ->where('user.data.id', $member->id)
            ->has('activities.data', 1)
            ->where('activities.data.0.event', 'updated')
            ->has('sessions.data', 1)
            ->where('sessions.data.0.ip_address', '127.0.0.1')
            ->where('sessions.data.0.browser', 'Google Chrome')
        );
});

test('panel member detail rejects admin users', function () {
    $viewer = User::factory()->admin()->create();
    $admin = User::factory()->admin()->create();

    $this->actingAs($viewer)
        ->get(route('panel.members.show', $admin))
        ->assertNotFound();
});

test('panel admin can create a member and send welcome mail', function () {
    Mail::fake();

    $viewer = User::factory()->admin()->create();

    $this->actingAs($viewer)
        ->post(route('panel.members.store'), [
            'name' => 'Created Member',
            'email' => 'created-member@example.com',
            'status' => UserStatus::Active->value,
            'email_verified' => true,
        ])
        ->assertRedirect();

    $created = User::query()
        ->where('email', 'created-member@example.com')
        ->firstOrFail();

    expect($created->name)->toBe('Created Member')
        ->and($created->user_type->isMember())->toBeTrue()
        ->and($created->status)->toBe(UserStatus::Active)
        ->and($created->email_verified_at)->not->toBeNull();

    Mail::assertSent(
        MemberWelcomeMail::class,
        fn (MemberWelcomeMail $mail): bool => $mail->hasTo($created->email)
            && $mail->verifiesEmail === false
            && str_contains($mail->welcomeUrl, 'token='),
    );

    $this->assertDatabaseHas('activity_log', [
        'subject_id' => $created->id,
        'causer_id' => $viewer->id,
        'event' => 'created',
    ]);
});

test('panel member welcome link verifies email before password reset when needed', function () {
    Mail::fake();

    $viewer = User::factory()->admin()->create();

    $this->actingAs($viewer)
        ->post(route('panel.members.store'), [
            'name' => 'Unverified Member',
            'email' => 'unverified-member@example.com',
            'status' => UserStatus::Active->value,
            'email_verified' => false,
        ])
        ->assertRedirect();

    $created = User::query()
        ->where('email', 'unverified-member@example.com')
        ->firstOrFail();

    expect($created->email_verified_at)->toBeNull();

    $welcomeUrl = null;

    Mail::assertSent(
        MemberWelcomeMail::class,
        function (MemberWelcomeMail $mail) use (&$welcomeUrl, $created): bool {
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

test('panel admin can verify a member email address', function () {
    Mail::fake();

    $viewer = User::factory()->admin()->create();
    $member = User::factory()->member()->unverified()->create();

    $this->actingAs($viewer)
        ->post(route('panel.members.email.verify', $member))
        ->assertRedirect();

    expect($member->fresh()->email_verified_at)->not->toBeNull();

    Mail::assertSent(
        MemberEmailVerifiedMail::class,
        fn (MemberEmailVerifiedMail $mail): bool => $mail->hasTo($member->email),
    );

    $this->assertDatabaseHas('activity_log', [
        'subject_id' => $member->id,
        'causer_id' => $viewer->id,
        'event' => 'email_verified',
    ]);
});

test('panel admin can request a member email change and close sessions', function () {
    config(['session.driver' => 'database']);
    Mail::fake();

    $viewer = User::factory()->admin()->create();
    $member = User::factory()->member()->create();
    $newEmail = 'new-member@example.com';

    DB::table('sessions')->insert([
        'id' => 'session-id',
        'user_id' => $member->id,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Feature Test',
        'payload' => 'payload',
        'last_activity' => now()->getTimestamp(),
    ]);

    $authentication = $member->authentications()->create([
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Feature Test',
        'login_at' => now(),
    ]);

    $this->actingAs($viewer)
        ->post(route('panel.members.email.change', $member), [
            'email' => $newEmail,
        ])
        ->assertRedirect();

    $this->assertDatabaseMissing('sessions', [
        'id' => 'session-id',
    ]);

    expect($authentication->fresh()->logout_at)->not->toBeNull();

    Mail::assertSent(
        MemberEmailChangeRequestedMail::class,
        fn (MemberEmailChangeRequestedMail $mail): bool => $mail->hasTo($newEmail)
            && $mail->email === $newEmail
            && str_contains($mail->confirmationUrl, 'email='),
    );

    $this->assertDatabaseHas('activity_log', [
        'subject_id' => $member->id,
        'causer_id' => $viewer->id,
        'event' => 'email_change_requested',
    ]);
});

test('panel member email change can be confirmed with a signed link', function () {
    config(['session.driver' => 'database']);

    $member = User::factory()->member()->create([
        'email' => 'old-member@example.com',
    ]);
    $newEmail = 'confirmed-member@example.com';

    DB::table('sessions')->insert([
        'id' => 'session-id',
        'user_id' => $member->id,
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Feature Test',
        'payload' => 'payload',
        'last_activity' => now()->getTimestamp(),
    ]);

    $authentication = $member->authentications()->create([
        'ip_address' => '127.0.0.1',
        'user_agent' => 'Feature Test',
        'login_at' => now(),
    ]);

    $url = URL::temporarySignedRoute(
        'panel.members.email.confirm',
        now()->addDay(),
        [
            'user' => $member->id,
            'email' => $newEmail,
        ],
    );

    $this->get($url)->assertRedirect(route('login'));

    $member->refresh();

    expect($member->email)->toBe($newEmail)
        ->and($member->email_verified_at)->not->toBeNull()
        ->and($authentication->fresh()->logout_at)->not->toBeNull();

    $this->assertDatabaseMissing('sessions', [
        'id' => 'session-id',
    ]);

    $this->assertDatabaseHas('activity_log', [
        'subject_id' => $member->id,
        'causer_id' => $member->id,
        'event' => 'email_changed',
    ]);
});

test('panel admin can update a member status', function () {
    Mail::fake();

    $viewer = User::factory()->admin()->create();
    $member = User::factory()->member()->create();

    $this->actingAs($viewer)
        ->patch(route('panel.members.status', $member), [
            'status' => UserStatus::Passive->value,
        ])
        ->assertRedirect();

    expect($member->fresh()->status)->toBe(UserStatus::Passive);

    Mail::assertSent(
        MemberStatusUpdatedMail::class,
        fn (MemberStatusUpdatedMail $mail): bool => $mail->hasTo($member->email)
            && $mail->status === UserStatus::Passive,
    );

    $this->assertDatabaseHas('activity_log', [
        'subject_id' => $member->id,
        'causer_id' => $viewer->id,
        'event' => 'status_updated',
    ]);
});
