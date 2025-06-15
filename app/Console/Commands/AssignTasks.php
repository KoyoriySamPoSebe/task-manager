<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\Employee;
use Illuminate\Support\Facades\Log;

class AssignTasks extends Command
{
    protected $signature = 'tasks:assign-unassigned';

    protected $description = 'Assign unassigned tasks to employees';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $unassignedTasks = Task::whereNull('employee_id')->get();
        $employees       = Employee::where('status', 'working')->get();

        if ($unassignedTasks->isEmpty() || $employees->isEmpty()) {
            $this->info('No unassigned tasks or no available employees.');

            return;
        }

        foreach ($unassignedTasks as $task) {
            $randomEmployee    = $employees->random();
            $task->employee_id = $randomEmployee->id;
            $task->save();

            Log::info("Task {$task->id} assigned to employee {$randomEmployee->id}");
        }

        $this->info('Unassigned tasks have been successfully assigned.');
    }
}
