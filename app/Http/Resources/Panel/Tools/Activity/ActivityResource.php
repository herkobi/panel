<?php

declare(strict_types=1);

namespace App\Http\Resources\Panel\Tools\Activity;

use App\Support\ActivitySubjectLabels;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Activitylog\Models\Activity;

/**
 * @mixin Activity
 */
class ActivityResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'log_name' => $this->log_name,
            'description' => $this->description,
            'event' => $this->event,
            'subject_type' => $this->subject_type ? class_basename($this->subject_type) : null,
            'subject_label' => ActivitySubjectLabels::for($this->subject_type),
            'subject_id' => $this->subject_id,
            'causer_type' => $this->causer_type ? class_basename($this->causer_type) : null,
            'causer_id' => $this->causer_id,
            'causer' => $this->whenLoaded('causer', function () {
                if (! $this->causer) {
                    return null;
                }

                return [
                    'id' => $this->causer->id,
                    'name' => $this->causer->name ?? null,
                    'email' => $this->causer->email ?? null,
                ];
            }),
            'properties' => $this->properties,
            'created_at' => $this->created_at,
        ];
    }
}
