<?php

declare(strict_types=1);

namespace App\Http\Controllers\App\Profile;

use App\Http\Controllers\Controller;
use App\Http\Resources\App\Profile\NotificationResource;
use App\Http\Resources\PaginatedResource;
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

        return Inertia::render('app/profile/notifications', [
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
