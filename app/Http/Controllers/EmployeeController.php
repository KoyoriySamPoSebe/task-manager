<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Services\EmployeeService;
use App\Http\Resources\EmployeeResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    protected EmployeeService $employeeService;

    public function __construct(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function index(Request $request): JsonResponse
    {
        $filters    = $request->only(['status', 'start_date', 'end_date', 'sort_by', 'order']);
        $pagination = $request->get('pagination', true);

        $employees = $this->employeeService->getAll($filters, $pagination);

        return response()->json(EmployeeResource::collection($employees));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:employees,email',
            'status' => 'required|in:working,on_leave',
        ]);

        $employee = $this->employeeService->create($validated);

        return response()->json(new EmployeeResource($employee), 201);
    }

    public function show(int $id): JsonResponse
    {
        $employee = $this->employeeService->find($id);

        return response()->json(new EmployeeResource($employee));
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required',
            'status' => 'required|in:working,on_leave',
        ]);

        $this->employeeService->update($id, $validated);

        return response()->json(null, 204);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->employeeService->delete($id);

        return response()->json(null, 204);
    }

    public function assignRole(Request $request, int $employeeId): JsonResponse
    {
        $validated = $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        $employee = $this->employeeService->assignRole($employeeId, $validated['role']);

        return response()->json([
            'message' => 'Role assigned successfully.',
            'employee' => new EmployeeResource($employee),
        ]);
    }

    public function removeRole(Request $request, int $employeeId): JsonResponse
    {
        $validated = $request->validate([
            'role' => 'required|string|exists:roles,name',
        ]);

        $employee = $this->employeeService->removeRole($employeeId, $validated['role']);

        return response()->json([
            'message' => 'Role removed successfully.',
            'employee' => new EmployeeResource($employee),
        ]);
    }
}
