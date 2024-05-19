<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Enums\AccountStatus;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use App\Http\Responses\LoginResponse;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;

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

        Fortify::loginView(function () {
            return view('auth.login');
        });

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('auth.password.forgot');
        });

        Fortify::resetPasswordView(function (Request $request) {
            return view('auth.password.reset', ['request' => $request]);
        });

        Fortify::verifyEmailView(function () {
            return view('auth.email-verify');
        });

        Fortify::confirmPasswordView(function () {
            return view('auth.password.confirm');
        });

        Fortify::twoFactorChallengeView(function () {
            return view('auth.two-factor-challenge');
        });

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower($request->input(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        //active-draft-passive route
        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);
        $this->app->singleton(TwoFactorLoginResponseContract::class, LoginResponse::class);

        Fortify::authenticateUsing (function (Request $request) {
            $user = User::where('email', $request->email)->where('status', '!=', AccountStatus::DELETED )->first();

            $agent = new Agent();
            $device = $agent->device();
            $browser = $agent->browser();
            $browser_version = $agent->version($browser);
            $os = $agent->platform();
            $os_version = $agent->version($os);
            $language = $agent->languages();

            if ($user && Hash::check($request->password, $user->password)) {

                $user->update([
                    'last_login_at' => Carbon::now()->toDateTimeString(),
                    'last_login_ip' => $request->getClientIp(),
                    'agent' => json_encode([
                        'device' => $device,
                        'os' => $os,
                        'os_version' => $os_version,
                        'browser' => $browser,
                        'browser_version' => $browser_version,
                        'language' => implode(',', $language)
                    ]),
                ]);

                return $user;
            }
        });
    }
}
