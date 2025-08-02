<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogModelEvents
{
    /**
     * Boot the trait and register model event listeners.
     */
    public static function bootLogModelEvents()
    {
        static::created(function ($model) {
            $model->logEvent('created');
        });

        static::updated(function ($model) {
            $model->logEvent('updated', $model->getOriginal());
        });

    }

    /**
     * Log the model event.
     * @param string $action
     * @param array $data
     * @param array $oldValues
     * @return void
     */
    public function logEvent(string $action, array $oldValues = null): void
    {
        ActivityLog::create([
            'user_id' => auth()->id(),
            'model' => class_basename($this),
            'model_id' => $this->id,
            'action' => $action,
            'data' => json_encode($this->getAttributes()),
            'old_values' => $oldValues ? json_encode($oldValues) : null,
        ]);
    }

}
