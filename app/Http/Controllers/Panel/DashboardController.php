<?php

declare(strict_types=1);

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    /**
     * Show the user's dashboard page.
     */
    public function index(): Response
    {
        return Inertia::render('panel/dashboard');
    }
}
