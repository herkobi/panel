<?php

declare(strict_types=1);

namespace App\Http\Controllers\Panel\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\Profile\EmailUpdateRequest;
use App\Http\Requests\Panel\Profile\ProfileUpdateRequest;
use App\Models\User;
use App\Services\Panel\Profile\ProfileService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class ProfileController extends Controller
{
    /**
     * Show the user's profile settings page.
     */
    public function edit(Request $request): Response
    {
        return Inertia::render('panel/profile/profile', [
            'mustVerifyEmail' => $request->user() instanceof MustVerifyEmail,
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request, ProfileService $service): RedirectResponse
    {
        $service->update($request->user(), $request->validated());

        return to_route('panel.profile.edit')
            ->with('toast', ['type' => 'success', 'message' => __('Profil güncellendi.')]);
    }

    public function updateEmail(EmailUpdateRequest $request, ProfileService $service): RedirectResponse
    {
        $user = $service->updateEmail($request->user(), (string) $request->validated('email'));

        $this->logoutUserFromAllSessions($request, $user);

        return redirect()
            ->route('login')
            ->with('toast', [
                'type' => 'success',
                'message' => __('E-posta adresiniz güncellendi. Yeni adresinizi doğrulamak için gönderilen e-postayı kontrol edin.'),
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
