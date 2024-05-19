<?php

namespace App\Http\Controllers\Admin\Tools;

use App\Http\Controllers\Controller;
use App\Actions\Admin\Tools\Activities\AccountActivities;
use App\Actions\Admin\Tools\Activities\UserActivities;
use Illuminate\View\View;

class ActivitiesController extends Controller
{
    private $accountActivities;
    private $userActivities;

    public function __construct(
        AccountActivities $accountActivities,
        UserActivities $userActivities,
    ) {
        $this->accountActivities = $accountActivities;
        $this->userActivities = $userActivities;
    }

    public function index(): View
    {
        $activities = $this->accountActivities->execute();
        return view('admin.tools.activities.accounts', [
            'activities' => $activities
        ]);
    }

    public function users(): View
    {
        $activities = $this->userActivities->execute();
        return view('admin.tools.activities.users', [
            'activities' => $activities
        ]);
    }
}
