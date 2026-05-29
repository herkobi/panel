<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Enums\UserType;
use App\Support\Branding;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();

        $authUserPayload = null;
        if ($user !== null) {
            $authUserPayload = $user->toArray();
            $authUserPayload['roles'] = $user->getRoleNames()->all();
            $authUserPayload['permissions'] = $user->getAllPermissions()->pluck('name')->all();
        }

        return [
            ...parent::share($request),
            'name' => Branding::name(),
            'branding' => Branding::toArray(),
            'auth' => [
                'type' => $user?->user_type === UserType::Admin ? 'panel' : 'app',
                'user' => $authUserPayload,
            ],
            'flash' => [
                'toast' => $request->session()->get('toast'),
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
                'warning' => $request->session()->get('warning'),
                'info' => $request->session()->get('info'),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
        ];
    }
}
