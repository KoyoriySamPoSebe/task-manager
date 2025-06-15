<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Task;
use App\Models\Employee;
use App\Repositories\TaskRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Validation\ValidationException;

class TaskService
{
    protected TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function create(array $data): Task
    {
        return $this->taskRepository->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->taskRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->taskRepository->delete($id);
    }

    public function getAll(array $filters = [], bool $pagination = true): Collection|LengthAwarePaginator
    {
        return $this->taskRepository->getAll($filters, $pagination);
    }

    public function find(int $id): Task
    {
        return $this->taskRepository->find($id);
    }

    public function assignEmployee(int $taskId, int $employeeId): Task
    {
        $task     = $this->taskRepository->find($taskId);
        $employee = Employee::findOrFail($employeeId);

        if ($employee->status === 'on_leave') {
            throw new ValidationException('Employee is on leave and cannot be assigned a task.');
        }

        $task->employees()->syncWithoutDetaching([$employeeId]);

        return $task;
    }

    public function removeEmployee(int $taskId): void
    {
        $task = $this->taskRepository->find($taskId);
        $task->employees()->detach();
    }
}
