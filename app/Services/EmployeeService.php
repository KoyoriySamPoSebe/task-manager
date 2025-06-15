<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\EmployeeRepository;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeService
{
    protected EmployeeRepository $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function create(array $data): Employee
    {
        return $this->employeeRepository->create($data);
    }

    public function update(int $id, array $data): bool
    {
        return $this->employeeRepository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->employeeRepository->delete($id);
    }

    public function getAll(array $filters = [], bool $pagination = true): Collection|LengthAwarePaginator
    {
        return $this->employeeRepository->getAll($filters, $pagination);
    }

    public function find(int $id): Employee
    {
        return $this->employeeRepository->find($id);
    }

    public function assignRole(int $employeeId, string $roleName): Employee
    {
        return $this->employeeRepository->assignRole($employeeId, $roleName);
    }

    public function removeRole(int $employeeId, string $roleName): Employee
    {
        return $this->employeeRepository->removeRole($employeeId, $roleName);
    }
}
