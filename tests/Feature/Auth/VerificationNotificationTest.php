<?php

declare(strict_types=1);

use App\Models\User;
use App\Notifications\Auth\VerifyEmailNotification;
use Illuminate\Support\Facades\Notification;
use Laravel\Fortify\Features;

beforeEach(function () {
    $this->skipUnlessFortifyHas(Features::emailVerification());
});

test('sends verification notification', function () {
    Notification::fake();

    $user = User::factory()->unverified()->create();

    $this->actingAs($user)
        ->post(route('verification.send'))
        ->assertRedirect(route('home'));

    Notification::assertSentTo($user, VerifyEmailNotification::class);
});

test('verification notification request creates database notification and activity', function () {
    $user = User::factory()->unverified()->create();

    $this->actingAs($user)
        ->post(route('verification.send'))
        ->assertRedirect();

    $notification = $user->notifications()->first();

    expect($notification)->not->toBeNull();
    expect($notification?->type)->toBe(VerifyEmailNotification::class);
    expect($notification?->data)->toMatchArray([
        'type' => 'auth.email_verification_requested',
    ]);

    $this->assertDatabaseHas('activity_log', [
        'log_name' => 'auth',
        'event' => 'email_verification_requested',
        'subject_id' => $user->id,
        'causer_id' => $user->id,
    ]);
});

test('does not send verification notification if email is verified', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('verification.send'))
        ->assertRedirect(route('dashboard', absolute: false));

    Notification::assertNothingSent();
});
