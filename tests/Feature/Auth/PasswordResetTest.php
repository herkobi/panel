<?php

declare(strict_types=1);

use App\Models\User;
use App\Notifications\Auth\PasswordResetCompletedNotification;
use App\Notifications\Auth\ResetPasswordNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Laravel\Fortify\Features;

beforeEach(function () {
    $this->skipUnlessFortifyHas(Features::resetPasswords());
});

test('reset password link screen can be rendered', function () {
    $response = $this->get(route('password.request'));

    $response->assertOk();
});

test('reset password link can be requested', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('password.email'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPasswordNotification::class);
});

test('reset password request creates database notification and activity', function () {
    $user = User::factory()->create();

    $this->post(route('password.email'), ['email' => $user->email])
        ->assertSessionHasNoErrors();

    $notification = $user->notifications()->first();

    expect($notification)->not->toBeNull();
    expect($notification?->type)->toBe(ResetPasswordNotification::class);
    expect($notification?->data)->toMatchArray([
        'type' => 'auth.password_reset_requested',
    ]);

    $this->assertDatabaseHas('activity_log', [
        'log_name' => 'auth',
        'event' => 'password_reset_requested',
        'subject_id' => $user->id,
        'causer_id' => $user->id,
    ]);
});

test('reset password screen can be rendered', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('password.email'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPasswordNotification::class, function ($notification) {
        $response = $this->get(route('password.reset', $notification->token));

        $response->assertOk();

        return true;
    });
});

test('password can be reset with valid token', function () {
    Notification::fake();

    $user = User::factory()->create();

    $this->post(route('password.email'), ['email' => $user->email]);

    Notification::assertSentTo($user, ResetPasswordNotification::class, function ($notification) use ($user) {
        $response = $this->post(route('password.update'), [
            'token' => $notification->token,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('login'));

        return true;
    });
});

test('successful password reset creates completed notification and activity', function () {
    $user = User::factory()->create();
    $token = Password::broker()->createToken($user);

    $user->sendPasswordResetNotification($token);

    $requestedNotification = $user->notifications()->firstOrFail();

    $this->post(route('password.update'), [
        'token' => $token,
        'email' => $user->email,
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertRedirect(route('login'));

    expect($requestedNotification->data)->toMatchArray([
        'type' => 'auth.password_reset_requested',
    ]);

    $completedNotification = $user->notifications()
        ->where('type', PasswordResetCompletedNotification::class)
        ->first();

    expect($completedNotification)->not->toBeNull();
    expect($completedNotification?->data)->toMatchArray([
        'type' => 'auth.password_reset_completed',
    ]);

    $this->assertDatabaseHas('activity_log', [
        'log_name' => 'auth',
        'event' => 'password_reset_completed',
        'subject_id' => $user->id,
        'causer_id' => $user->id,
    ]);
});

test('password cannot be reset with invalid token', function () {
    $user = User::factory()->create();

    $response = $this->post(route('password.update'), [
        'token' => 'invalid-token',
        'email' => $user->email,
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ]);

    $response->assertSessionHasErrors('email');
});
