<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\EmployeeService;
use App\Http\Resources\EmployeeResource;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index()
    {
        $employees = $this->employeeService->getAll();
        return EmployeeResource::collection($employees);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:employees,email',
            'status' => 'required|in:working,on_leave',
        ]);

        $employee = $this->employeeService->create($validated);
        return response()->json(new EmployeeResource($employee), 201);
    }

    public function show(int $id)
    {
        $employee = $this->employeeService->find($id);
        return response()->json(new EmployeeResource($employee));
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'status' => 'required|in:working,on_leave',
        ]);

        $employee = $this->employeeService->update($id, $validated);
        return response()->json(new EmployeeResource($employee));
    }

    public function destroy(int $id)
    {
        $this->employeeService->delete($id);
        return response()->json(null, 204);
    }
}




