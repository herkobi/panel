<?php

declare(strict_types=1);

namespace App\Providers;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
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
        $this->configureDefaults();
        $this->configureAuthorization();
        $this->configureUserPreferences();
    }

    /**
     * Super Admin rolü TÜM yetkilere otomatik sahip — Spatie permission listesine
     * eklenmesine gerek yok. Diğer roller yalnızca açıkça atanmış izinlerle çalışır.
     */
    protected function configureAuthorization(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        // Üretim dışında N+1'i erken yakala: lazy loading'i yasakla.
        Model::preventLazyLoading(! app()->isProduction());

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }

    protected function configureUserPreferences(): void
    {
        // View render edilmeden önce (Inertia dahil) ayarları uygula
        view()->composer('*', function () {
            if (Auth::check()) {
                // Session'dan al, yoksa config'deki varsayılanı kullan
                $locale = session('locale', config('app.locale'));
                $timezone = session('timezone', config('app.timezone'));

                // Sistem ayarlarını çalışma zamanında güncelle
                app()->setLocale($locale);
                config(['app.timezone' => $timezone]);
                date_default_timezone_set($timezone);

                // Carbon için immutable desteğini ve yerelleştirmeyi koru[cite: 2]
                Carbon::setLocale($locale);
            }
        });
    }
}
