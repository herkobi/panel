<?php

namespace App\Listeners\Admin\Settings;

use App\Models\Activity;
use App\Services\LoggingService;
use App\Events\Admin\Settings\Settings as Event;
use App\Traits\LogActivity;

class Settings
{
    use LogActivity;

    protected $loggingService;
    protected $activity;

    public function __construct(LoggingService $loggingService, Activity $activity)
    {
        $this->loggingService = $loggingService;
        $this->activity = $activity;
    }

    public function handle(Event $event)
    {
        $changedSettings = $this->getChangedSettings($event->oldSettings, $event->newSettings);

        $this->loggingService->logUserAction(
            'settings.updated',
            $event->updatedBy,
            null,
            [
                'changed_settings' => json_encode($changedSettings)
            ]
        );

        Activity::create([
            'message' => 'settings.updated',
            'log' => $this->logActivity(
                ' user updated settings.',
                $event->updatedBy,
                null,
                [
                    'changed_settings' => json_encode($changedSettings)
                ]
            ),
        ]);
    }

    private function getChangedSettings(array $oldSettings, array $newSettings): array
    {
        $changedSettings = [];
        foreach ($newSettings as $key => $value) {
            if (!isset($oldSettings[$key]) || $oldSettings[$key] !== $value) {
                $changedSettings[$key] = [
                    'old' => $oldSettings[$key] ?? null,
                    'new' => $value
                ];
            }
        }
        return $changedSettings;
    }
}
