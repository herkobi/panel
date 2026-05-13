<?php

declare(strict_types=1);

namespace App\Http\Controllers\Panel\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaginatedResource;
use App\Http\Resources\Panel\Profile\NotificationResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class NotificationsController extends Controller
{
    /**
     * Show the user's notifications page.
     */
    public function index(Request $request): Response
    {
        $notifications = $request->user()
            ->notifications()
            ->latest()
            ->paginate(20);

        return Inertia::render('panel/profile/notifications', [
            'notifications' => PaginatedResource::make($notifications, NotificationResource::class, $request),
        ]);
    }

    public function markAsRead(Request $request, string $notification): RedirectResponse
    {
        $request->user()
            ->notifications()
            ->whereKey($notification)
            ->firstOrFail()
            ->markAsRead();

        return back();
    }
}
