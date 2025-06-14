<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Employee;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\RateLimiter;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->middleware('throttle:2,1')->only('store');
        $this->taskService = $taskService;
    }

    public function index(Request $request)
    {
        $filters       = $request->only(['status', 'assigned_to', 'start_date', 'end_date', 'sort_by', 'order']);
        $pagination    = $request->get('pagination', true);
        $groupByStatus = $request->get('group_by_status', false);

        $tasks = $this->taskService->getAll($filters, $pagination, $groupByStatus);

        return response()->json($tasks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required|in:to_do,in_progress,done',
        ]);

        $task = $this->taskService->create($validated);

        return response()->json($task, 201);
    }

    public function show(int $id)
    {
        $task = $this->taskService->find($id);

        return response()->json($task);
    }

    public function update(Request $request, int $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required|in:to_do,in_progress,done',
        ]);

        $this->taskService->update($id, $validated);

        return response()->json(null, 204);
    }

    public function destroy(int $id)
    {
        $this->taskService->delete($id);

        return response()->json(null, 204);
    }

    public function assignEmployee(Request $request, int $taskId)
    {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
        ]);

        $employeeId = $request->input('employee_id');

        $this->taskService->assignEmployee($taskId, $employeeId);

        return response()->json(null, 204);
    }

    public function removeEmployee(int $taskId)
    {
        $this->taskService->removeEmployee($taskId);

        return response()->json(null, 204);
    }
}
