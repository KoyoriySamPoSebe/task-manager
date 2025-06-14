<?php

namespace App\Events;

use App\Models\Task;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class TaskStatusUpdated
{
    use SerializesModels;

    public $task;

    public function __construct(Task $task)
    {
        $this->task = $task;

        Log::info('Task status updated event fired for Task ID: ' . $task->id);
    }
}
