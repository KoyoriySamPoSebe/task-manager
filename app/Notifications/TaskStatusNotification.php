<?php

namespace App\Notifications;

use App\Models\Task;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Support\Facades\Log;

class TaskStatusNotification extends Notification
{
    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        Log::info("Sending database notification for Task ID: {$this->task->id}");

        return [
            'task_id' => $this->task->id,
            'status' => $this->task->status,
            'message' => "Задача #{$this->task->id} была переведена в статус {$this->task->status}",
        ];
    }
}
