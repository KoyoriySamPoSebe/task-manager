<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Factories\EmployeeFactory;
use Database\Factories\TaskFactory;
use App\Models\Task;
use App\Models\Employee;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Employee::factory(20)->create();

        Task::factory(200)->create();
    }
}
