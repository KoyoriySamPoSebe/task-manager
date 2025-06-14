<?php

namespace App\Listeners;

use App\Events\TaskStatusUpdated;
use App\Notifications\TaskStatusNotification;
use Illuminate\Support\Facades\Log;

class SendTaskStatusNotification
{
    public function handle(TaskStatusUpdated $event)
    {
        $task = $event->task;

        Log::info("Task status updated: Task ID = {$task->id}, Status = {$task->status}");

        if (in_array($task->status, ['in_progress', 'done'])) {
            foreach ($task->employees as $employee) {
                Log::info("Sending notification to employee {$employee->id} for task {$task->id}");

                $employee->notify(new TaskStatusNotification($task));
            }
        }
    }
}
