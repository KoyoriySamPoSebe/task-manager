<?php

namespace App\Repositories;

use App\Models\Task;
use App\Interfaces\RepositoryInterface;

class TaskRepository implements RepositoryInterface
{
    public function getAll()
    {
        return Task::all();
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

