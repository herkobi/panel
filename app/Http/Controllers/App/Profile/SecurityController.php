<?php

declare(strict_types=1);

namespace App\Http\Controllers\App\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\App\Profile\PasswordUpdateRequest;
use App\Http\Requests\App\Profile\TwoFactorAuthenticationRequest;
use App\Models\User;
use App\Services\App\Profile\ProfileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Features;

class SecurityController extends Controller implements HasMiddleware
{
    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return Features::canManageTwoFactorAuthentication()
            && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
                ? [new Middleware('password.confirm', only: ['edit'])]
                : [];
    }

    /**
     * Show the user's security settings page.
     */
    public function edit(TwoFactorAuthenticationRequest $request): Response
    {
        $props = [
            'canManageTwoFactor' => Features::canManageTwoFactorAuthentication(),
        ];

        if (Features::canManageTwoFactorAuthentication()) {
            $request->ensureStateIsValid();

            $props['twoFactorEnabled'] = $request->user()->hasEnabledTwoFactorAuthentication();
            $props['requiresConfirmation'] = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirm');
        }

        return Inertia::render('app/profile/security', $props);
    }

    /**
     * Update the user's password.
     */
    public function update(PasswordUpdateRequest $request, ProfileService $service): RedirectResponse
    {
        $user = $service->updatePassword($request->user(), (string) $request->validated('password'));

        $this->logoutUserFromAllSessions($request, $user);

        return redirect()
            ->route('login')
            ->with('toast', [
                'type' => 'success',
                'message' => __('Şifreniz güncellendi. Lütfen yeni şifrenizle tekrar giriş yapın.'),
            ]);
    }

    private function logoutUserFromAllSessions(Request $request, User $user): void
    {
        Auth::guard('web')->logout();

        if (config('session.driver') === 'database') {
            DB::table(config('session.table', 'sessions'))
                ->where('user_id', $user->getKey())
                ->delete();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }
}
