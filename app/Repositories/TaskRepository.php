<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Task;
use App\Interfaces\RepositoryInterface;

class TaskRepository implements RepositoryInterface
{
    public function getAll(array $filters = [], $pagination = true, $groupByStatus = false)
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

        if ($pagination) {
            $tasks = $query->paginate(10);
        } else {
            $tasks = $query->get();
        }

        if ($groupByStatus) {
            return $tasks->groupBy('status');
        }

        return $tasks;
    }

    public function find(int $id)
    {
        return Task::findOrFail($id);
    }

    public function create(array $data)
    {
        return Task::create($data);
    }

    public function update(int $id, array $data)
    {
        Task::where('id', $id)->update($data);

        return true;
    }

    public function delete(int $id)
    {
        Task::where('id', $id)->delete();

        return true;
    }
}
