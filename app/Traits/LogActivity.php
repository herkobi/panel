<?php

namespace App\Traits;

trait LogActivity
{
    protected function logActivity(string $action, $performer, $subject, array $details = []): string
    {
        $log = sprintf(
            '%s %s %s.',
            $performer->name,
            $action,
            $subject->name ?? class_basename($subject)
        );

        foreach ($details as $key => $value) {
            $log .= sprintf(' %s: %s,', ucfirst($key), $value);
        }

        return rtrim($log, ',');
    }
}
