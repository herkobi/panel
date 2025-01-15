<?php

namespace App\Http\Controllers\Admin\Tools;

use App\Http\Controllers\Controller;
use App\Services\Admin\Tools\ActivitiesService;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\View;

class ActivitiesController extends Controller
{
    protected $activities;

    public function __construct(ActivitiesService $activities)
    {
        $this->activities = $activities;
    }

    public function users(): View|LengthAwarePaginator
    {
        $logs = $this->activities->usersActivities();
        return view('admin.tools.usersActivities', [
            'logs' => $logs
        ]);
    }

    public function admins(): View|LengthAwarePaginator
    {
        $logs = $this->activities->adminsActivities();
        return view('admin.tools.adminsActivities', [
            'logs' => $logs
        ]);
    }

    public function passwords(): View|LengthAwarePaginator
    {
        $logs = $this->activities->passwordsActivities();
        return view('admin.tools.passwordsActivities', [
            'logs' => $logs
        ]);
    }
}
