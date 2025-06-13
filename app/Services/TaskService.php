<?php

namespace App\Services;

use App\Repositories\TaskRepository;

class TaskService
{
    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function create(array $data)
    {
        return $this->taskRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $this->taskRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        $this->taskRepository->delete($id);
    }

    public function getAll()
    {
        return $this->taskRepository->getAll();
    }

    public function find(int $id)
    {
        return $this->taskRepository->find($id);
    }

    public function assignEmployee(int $taskId, int $employeeId)
    {
        $task = $this->taskRepository->find($taskId);
        if ($task) {
            $task->employees()->syncWithoutDetaching([$employeeId]);
        } else {
            throw new \Exception('Task not found');
        }
    }


    public function removeEmployee(int $taskId)
    {
        $task = $this->taskRepository->find($taskId);
        $task->employees()->detach();
    }
}

