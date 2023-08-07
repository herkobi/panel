<?php

namespace App\Http\Controllers\Activity;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Utils\PaginateCollection;
use Spatie\Activitylog\Models\Activity;

class AdminActivity extends Controller {


    public function index(): View
    {
        $events = Activity::pluck('event')->toArray();
        $models = Activity::pluck('subject_type')->toArray();
        $events = array_unique($events);
        $models = array_unique($models);

        $activities = Activity::where('log_name', 'admin')->get();
        $activities = PaginateCollection::paginate($activities, 5);
        return view('activity.admin', [
            'activities' => $activities,
            'events' => $events,
            'models' => $models
        ]);
    }
}
