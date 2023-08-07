<?php

namespace App\Http\Controllers\Activity;

use App\Http\Controllers\Controller;
use App\Utils\PaginateCollection;
use Spatie\Activitylog\Models\Activity;

class UserActivity extends Controller {


    public function index()
    {
        $activities = Activity::where('log_name', 'user')->get();
        $activities = PaginateCollection::paginate($activities, 5);
        return view('activity.user', ['activities' => $activities]);
    }
}
