<?php

declare(strict_types=1);

namespace App\Services\Panel\Tools\Activity;

use App\Models\User;
use App\Support\ActivitySubjectLabels;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Activitylog\Models\Activity;

class ActivityService
{
    /**
     * @param  array{user_id?: string, subject_type?: string, causer_id?: string, from?: string, to?: string}  $filters
     */
    public function paginate(array $filters): LengthAwarePaginator
    {
        return $this->query($filters)
            ->latest()
            ->paginate(30)
            ->withQueryString();
    }

    public function users(): Collection
    {
        return User::query()
            ->select(['id', 'name'])
            ->orderBy('name')
            ->get();
    }

    /**
     * @return array<int, array{value: string, label: string}>
     */
    public function subjectTypes(): array
    {
        return Activity::query()
            ->whereNotNull('subject_type')
            ->distinct()
            ->orderBy('subject_type')
            ->pluck('subject_type')
            ->map(fn (string $type): array => ActivitySubjectLabels::option($type))
            ->unique('value')
            ->sortBy('label', SORT_NATURAL)
            ->values()
            ->all();
    }

    /**
     * @param  array{user_id?: string, subject_type?: string, causer_id?: string, from?: string, to?: string}  $filters
     */
    private function query(array $filters): Builder
    {
        $query = Activity::query()->with('causer');

        $subjectType = $filters['subject_type'] ?? '';
        if ($subjectType !== '') {
            $query->where('subject_type', 'like', '%'.addcslashes($subjectType, '%_\\').'%');
        }

        $causerId = $filters['causer_id'] ?? '';
        if ($causerId !== '') {
            $query->where('causer_id', $causerId);
        }

        $from = $filters['from'] ?? '';
        if ($from !== '') {
            $query->where('created_at', '>=', $from.' 00:00:00');
        }

        $to = $filters['to'] ?? '';
        if ($to !== '') {
            $query->where('created_at', '<=', $to.' 23:59:59');
        }

        $userId = $filters['user_id'] ?? '';
        if ($userId !== '') {
            $query->where(function ($q) use ($userId) {
                $q->where(function ($inner) use ($userId) {
                    $inner->where('subject_type', User::class)
                        ->where('subject_id', $userId);
                })->orWhere('properties->user_id', $userId);
            });
        }

        return $query;
    }
}
