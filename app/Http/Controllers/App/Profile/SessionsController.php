<?php

declare(strict_types=1);

namespace App\Http\Controllers\App\Profile;

use App\Events\App\Profile\SessionRevokedEvent;
use App\Http\Controllers\Controller;
use App\Http\Resources\App\Profile\SessionResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class SessionsController extends Controller
{
    /**
     * Show the user's sessions page.
     */
    public function index(Request $request): Response
    {
        return Inertia::render('app/profile/sessions', [
            'last_login_at' => $request->user()?->last_login_at,
            'sessions' => SessionResource::collection($this->activeSessions($request)),
        ]);
    }

    public function destroy(Request $request, string $session): RedirectResponse
    {
        $targetSession = DB::table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getKey())
            ->where('id', $session)
            ->first();

        abort_if(! $targetSession || $targetSession->id === $request->session()->getId(), 404);

        DB::table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getKey())
            ->where('ip_address', $targetSession->ip_address)
            ->where('user_agent', $targetSession->user_agent)
            ->where('id', '!=', $request->session()->getId())
            ->delete();

        $request->user()
            ->authentications()
            ->where('ip_address', $targetSession->ip_address)
            ->where('user_agent', $targetSession->user_agent)
            ->whereNull('logout_at')
            ->update(['logout_at' => now()]);

        SessionRevokedEvent::dispatch(
            $request->user(),
            $targetSession->ip_address,
            $targetSession->user_agent,
        );

        return back()->with('toast', [
            'type' => 'success',
            'message' => __('Oturum kapatıldı.'),
        ]);
    }

    /**
     * @return Collection<int, object>
     */
    private function activeSessions(Request $request): Collection
    {
        $expiresAt = now()
            ->subMinutes((int) config('session.lifetime', 120))
            ->getTimestamp();
        $currentSessionId = $request->session()->getId();

        return DB::table(config('session.table', 'sessions'))
            ->where('user_id', $request->user()->getKey())
            ->where('last_activity', '>=', $expiresAt)
            ->orderByDesc('last_activity')
            ->get()
            ->groupBy(fn (object $session): string => ($session->ip_address ?? '').'|'.($session->user_agent ?? ''))
            ->map(function (Collection $sessions) use ($currentSessionId, $request): object {
                $currentSession = $sessions->firstWhere('id', $currentSessionId);
                $session = $currentSession ?? $sessions->first();
                $authentication = $request->user()
                    ->authentications()
                    ->where('ip_address', $session->ip_address)
                    ->where('user_agent', $session->user_agent)
                    ->first();

                $session->is_current = $currentSession !== null;
                $session->session_count = $sessions->count();
                $session->login_at = $authentication?->login_at;

                return $session;
            })
            ->sortByDesc('last_activity')
            ->values();
    }
}
