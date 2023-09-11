<?php

namespace App\Http\Controllers\Activity;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Utils\PaginateCollection;
use Spatie\Activitylog\Models\Activity as ActivityModel;

class Activity extends Controller {


    public function index(): View
    {
        $events = ActivityModel::pluck('event')->toArray();
        $models = ActivityModel::pluck('subject_type')->toArray();
        $events = array_unique($events);
        $models = array_unique($models);

        $activities = ActivityModel::where('log_name', 'admin')->get();
        $activities = PaginateCollection::paginate($activities, 25);
        return view('activity.index', [
            'activities' => $activities,
            'events' => $events,
            'models' => $models
        ]);
    }

    public function users(): View
    {
        $events = ActivityModel::pluck('event')->toArray();
        $models = ActivityModel::pluck('subject_type')->toArray();
        $events = array_unique($events);
        $models = array_unique($models);

        $activities = ActivityModel::where('log_name', 'user')->get();
        $activities = PaginateCollection::paginate($activities, 5);
        return view('activity.user', [
            'activities' => $activities,
            'events' => $events,
            'models' => $models
        ]);
    }
}
