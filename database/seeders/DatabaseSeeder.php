<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Task;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $employees = Employee::factory(20)->create();
        $tasks     = Task::factory(200)->create();

        $this->call(RolesSeeder::class);

        foreach ($tasks as $task) {
            $task->employees()->attach($employees->random(rand(1, 3))->pluck('id')->toArray());
        }

        $programmerRole = Role::findByName('programmer', 'api');
        $managerRole    = Role::findByName('manager', 'api');

        foreach ($employees as $index => $employee) {
            if ($index < 10) {
                $employee->assignRole([$programmerRole, $managerRole]);
            } else {
                $role = $index % 2 === 0 ? $programmerRole : $managerRole;
                $employee->assignRole($role);
            }
        }
    }
}
