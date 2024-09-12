<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class LoggingService
{
    public function logUserAction(string $action, $user, ?Model $relatedModel = null, array $additionalData = [])
    {
        $logData = [
            'user_id' => $user->id,
            'ip_address' => request()->ip(),
            'time' => now()->toDateTimeString(),
        ];

        if ($relatedModel) {
            $logData[strtolower(class_basename($relatedModel)) . '_id'] = $relatedModel->id;
        }

        $logData = array_merge($logData, $additionalData);

        $message = trans('logs.' . $action, array_merge([
            'user' => $user->name . ' ' . $user->surname,
            'model' => $relatedModel ? $relatedModel->title : null,
        ], $additionalData));

        Log::info($message, $logData);
    }
}
