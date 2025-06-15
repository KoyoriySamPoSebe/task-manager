<?php

namespace App\Providers;

use App\Events\TaskStatusUpdated;
use App\Listeners\SendTaskStatusNotification;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        TaskStatusUpdated::class => [
            SendTaskStatusNotification::class,
        ],
    ];

    public function boot()
    {
        parent::boot();
    }
}
