<?php

declare(strict_types=1);

namespace App\Http\Controllers\Panel\Tools\Activity;

use App\Http\Controllers\Controller;
use App\Http\Resources\PaginatedResource;
use App\Http\Resources\Panel\Tools\Activity\ActivityResource;
use App\Services\Panel\Tools\Activity\ActivityService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ActivityController extends Controller
{
    public function index(Request $request, ActivityService $service): Response
    {
        $filters = $this->filters($request);
        $activities = PaginatedResource::make(
            $service->paginate($filters),
            ActivityResource::class,
            $request
        );

        return Inertia::render('panel/tools/activity/index', [
            'activities' => $activities,
            'filters' => $filters,
            'causer_types' => $service->causerTypes(),
            'subject_types' => $service->subjectTypes(),
        ]);
    }

    /**
     * @return array<string, string>
     */
    private function filters(Request $request): array
    {
        return [
            'user_id' => $request->string('user_id')->toString(),
            'subject_type' => $request->string('subject_type')->toString(),
            'causer_type' => $request->string('causer_type')->toString(),
            'from' => $request->string('from')->toString(),
            'to' => $request->string('to')->toString(),
        ];
    }
}
