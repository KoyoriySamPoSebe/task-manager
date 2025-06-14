<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\EmployeeRepository;

class EmployeeService
{
    protected $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function create(array $data)
    {
        return $this->employeeRepository->create($data);
    }

    public function update(int $id, array $data)
    {
        $this->employeeRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        $this->employeeRepository->delete($id);
    }

    public function getAll()
    {
        return $this->employeeRepository->getAll();
    }

    public function find(int $id)
    {
        return $this->employeeRepository->find($id);
    }
}
