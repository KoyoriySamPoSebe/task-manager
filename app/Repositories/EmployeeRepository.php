<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Employee;
use App\Interfaces\RepositoryInterface;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EmployeeRepository implements RepositoryInterface
{
    public function getAll(array $filters = [], bool $pagination = true): Collection|LengthAwarePaginator
    {
        $query = Employee::query();

        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['start_date']) && isset($filters['end_date'])) {
            $query->whereBetween('created_at', [$filters['start_date'], $filters['end_date']]);
        }

        if (isset($filters['sort_by']) && isset($filters['order'])) {
            $query->orderBy($filters['sort_by'], $filters['order']);
        }

        if ($pagination) {
            return $query->paginate(10);
        }

        return $query->get();
    }

    public function find(int $id): Employee
    {
        return Employee::findOrFail($id);
    }

    public function create(array $data): Employee
    {
        return Employee::create($data);
    }

    public function update(int $id, array $data): bool
    {
        Employee::where('id', $id)->update($data);

        return true;
    }

    public function delete(int $id): bool
    {
        Employee::where('id', $id)->delete();

        return true;
    }

    public function assignRole(int $employeeId, string $roleName): Employee
    {
        $employee = Employee::findOrFail($employeeId);
        $employee->assignRole($roleName);

        return $employee->load('roles');
    }

    public function removeRole(int $employeeId, string $roleName): Employee
    {
        $employee = Employee::findOrFail($employeeId);
        $employee->removeRole($roleName);

        return $employee->load('roles');
    }
}
