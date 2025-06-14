<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->text,
            'status' => $this->faker->randomElement(['to_do', 'in_progress', 'done']),
            'employee_id' => $this->faker->randomElement(Employee::pluck('id')->toArray()), // случайный сотрудник
        ];
    }
}
