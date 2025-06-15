<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Task;
use App\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TaskRepository implements RepositoryInterface
{
    public function getAll(array $filters = [], bool $pagination = true, bool $groupByStatus = false): Collection|LengthAwarePaginator
    {
        $query = Task::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['assigned_to'])) {
            $query->where('employee_id', $filters['assigned_to']);
        }

        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }

        if (isset($filters['sort_by']) && isset($filters['order'])) {
            $query->orderBy($filters['sort_by'], $filters['order']);
        }

        $query->with('employees');

        $tasks = $pagination ? $query->paginate(10) : $query->get();

        if ($groupByStatus) {
            return $tasks->groupBy('status');
        }

        return $tasks;
    }

    public function find(int $id): Task
    {
        return Task::with('employees')->findOrFail($id);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(int $id, array $data): bool
    {
        Task::where('id', $id)->update($data);

        return true;
    }

    public function delete(int $id): bool
    {
        Task::where('id', $id)->delete();

        return true;
    }
}
