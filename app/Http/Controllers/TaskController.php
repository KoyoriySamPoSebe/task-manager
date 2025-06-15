<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\TaskService;
use App\Http\Resources\TaskResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->middleware('throttle:2,1')->only('store');
        $this->taskService = $taskService;
    }

    public function index(Request $request): JsonResponse
    {
        $filters    = $request->only(['status', 'assigned_to', 'start_date', 'end_date', 'sort_by', 'order']);
        $pagination = $request->get('pagination', true);

        $tasks = $this->taskService->getAll($filters, $pagination);

        return response()->json(TaskResource::collection($tasks));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required|in:to_do,in_progress,done',
        ]);

        $task = $this->taskService->create($validated);

        return response()->json(new TaskResource($task), 201);
    }

    public function show(int $id): JsonResponse
    {
        $task = $this->taskService->find($id);

        return response()->json(new TaskResource($task));
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required|in:to_do,in_progress,done',
        ]);

        $this->taskService->update($id, $validated);

        return response()->json(null, 204);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->taskService->delete($id);

        return response()->json(null, 204);
    }

    public function assignEmployee(Request $request, int $taskId): JsonResponse
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        $employeeId = $request->input('employee_id');

        $this->taskService->assignEmployee($taskId, $employeeId);

        return response()->json(null, 204);
    }

    public function removeEmployee(int $taskId): JsonResponse
    {
        $this->taskService->removeEmployee($taskId);

        return response()->json(null, 204);
    }
}
