<?php

namespace App\Repositories;

use App\Models\Employee;
use App\Interfaces\RepositoryInterface;

class EmployeeRepository implements RepositoryInterface
{
    public function getAll()
    {
        return Employee::all();
    }

    public function find(int $id)
    {
        return Employee::findOrFail($id);
    }

    public function create(array $data)
    {
        return Employee::create($data);
    }

    public function update(int $id, array $data)
    {
        Employee::where('id', $id)->update($data);
        return true;
    }

    public function delete(int $id)
    {
        Employee::where('id', $id)->delete();
        return true;
    }
}

