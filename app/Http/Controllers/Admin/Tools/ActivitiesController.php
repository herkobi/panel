<?php

namespace App\Http\Controllers\Admin\Tools;

use App\Http\Controllers\Controller;
use App\Actions\Admin\Tools\Activities\AccountActivities;
use App\Actions\Admin\Tools\Activities\UserActivities;
use Illuminate\Support\Facades\Redirect;
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
        if (!auth()->user()->can('tools.accounts.activities')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $activities = $this->accountActivities->execute();
        return view('admin.tools.activities.accounts', [
            'activities' => $activities
        ]);
    }

    public function users(): View
    {
        if (!auth()->user()->can('tools.user.activities')) {
            return Redirect::back()->with('error', __('admin/global.permission.error'));
        }

        $activities = $this->userActivities->execute();
        return view('admin.tools.activities.users', [
            'activities' => $activities
        ]);
    }
}
