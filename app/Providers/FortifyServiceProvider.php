<?php

declare(strict_types=1);

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureActions();
        $this->configureViews();
        $this->configureRateLimiting();
        $this->configureLoginTracking();
    }

    /**
     * Configure Fortify actions.
     */
    private function configureActions(): void
    {
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);
        Fortify::createUsersUsing(CreateNewUser::class);
    }

    /**
     * Configure Fortify views.
     */
    private function configureViews(): void
    {
        Fortify::loginView(fn (Request $request) => Inertia::render('auth/login', [
            'canResetPassword' => Features::enabled(Features::resetPasswords()),
            'canRegister' => Features::enabled(Features::registration()),
            'status' => $request->session()->get('status'),
        ]));

        Fortify::resetPasswordView(fn (Request $request) => Inertia::render('auth/reset-password', [
            'email' => $request->email,
            'token' => $request->route('token'),
        ]));

        Fortify::requestPasswordResetLinkView(fn (Request $request) => Inertia::render('auth/forgot-password', [
            'status' => $request->session()->get('status'),
        ]));

        Fortify::verifyEmailView(fn (Request $request) => Inertia::render('auth/verify-email', [
            'status' => $request->session()->get('status'),
        ]));

        Fortify::registerView(fn () => Inertia::render('auth/register'));

        Fortify::twoFactorChallengeView(fn () => Inertia::render('auth/two-factor-challenge'));

        Fortify::confirmPasswordView(fn () => Inertia::render('auth/confirm-password'));
    }

    /**
     * Configure rate limiting.
     */
    private function configureRateLimiting(): void
    {
        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        // Spam kayıt koruması: IP başına dakikada 5 deneme.
        RateLimiter::for('register', function (Request $request) {
            return Limit::perMinute(5)->by($request->ip());
        });

        // Şifre sıfırlama maili spam'i ve account enumeration koruması:
        // e-posta + IP kombinasyonu başına dakikada 3 deneme.
        RateLimiter::for('password-email', function (Request $request) {
            $key = Str::transliterate(Str::lower((string) $request->input('email')).'|'.$request->ip());

            return Limit::perMinute(3)->by($key);
        });

        // Şifre sıfırlama tamamlama: IP başına dakikada 3 deneme.
        RateLimiter::for('password-update', function (Request $request) {
            return Limit::perMinute(3)->by($request->ip());
        });
    }

    /**
     * Configure login tracking and session preferences.
     */
    private function configureLoginTracking(): void
    {
        Event::listen(Login::class, function (Login $event) {
            /** @var User $user */
            $user = $event->user;

            // Son giriş tarihini güncelle
            $user->forceFill([
                'last_login_at' => now(),
            ])->save();

            // loadMissing ile dil ilişkisini verimli çekiyoruz
            $user->loadMissing('language');

            session([
                'locale' => $user->language?->code ?? $user->getAttribute('locale') ?? config('app.locale'),
                'timezone' => $user->timezone ?? config('app.timezone'),
            ]);
        });
    }
}
