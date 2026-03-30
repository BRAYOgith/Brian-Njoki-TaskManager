<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskStatusRequest;
use App\Models\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request): JsonResponse
    {

        $tasks = Task::filterByStatus($request->get('status'))
            ->orderByRaw("FIELD(priority, 'high', 'medium', 'low')")
            ->orderBy('due_date', 'asc')
            ->get();

        if ($tasks->isEmpty()) {
            return response()->json([
                'message' => 'No tasks found.',
                'data' => [],
            ]);
        }

        return response()->json($tasks);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {

        $task = Task::create($request->validated());

        return response()->json([
            'message' => 'Task created successfully.',
            'data' => $task,
        ], 201);
    }

    public function updateStatus(Task $task, UpdateTaskStatusRequest $request): JsonResponse
    {
        $newStatus = $request->status;

        if (! $task->canTransitionTo($newStatus) && $task->status !== $newStatus) {
            return response()->json([
                'message' => 'Invalid status transition.',
                'error' => "Task cannot transition from '{$task->status}' to '{$newStatus}'. Status can only progress: pending → in_progress → done.",
            ], 422);
        }

        if ($newStatus === 'done' && $task->status === 'in_progress') {
            if ($task->due_date && $task->due_date->startOfDay()->isFuture()) {
                return response()->json([
                    'message' => 'Task cannot be completed early.',
                    'error' => 'You cannot mark this task as completed before its due date ('.$task->due_date->format('M j, Y').').',
                ], 422);
            }
        }

        $task->update(['status' => $newStatus]);

        return response()->json([
            'message' => 'Task status updated successfully.',
            'data' => $task,
        ]);
    }

    public function destroy(Task $task): JsonResponse
    {

        if ($task->status !== 'done') {
            return response()->json([
                'message' => 'Cannot delete task that is not completed.',
                'error' => 'Only tasks with status "done" can be deleted.',
            ], 403);
        }

        $task->delete();

        return response()->json([
            'message' => 'Task deleted successfully.',
        ]);
    }

    public function dailyReport(Request $request): JsonResponse
    {
        $date = $request->get('date', now()->toDateString());

        $tasks = Task::whereDate('due_date', $date)->get();

        $summary = [];
        foreach (['high', 'medium', 'low'] as $priority) {
            $summary[$priority] = [];
            foreach (['pending', 'in_progress', 'done'] as $status) {
                $summary[$priority][$status] = $tasks->where('priority', $priority)->where('status', $status)->count();
            }
        }

        return response()->json([
            'date' => $date,
            'summary' => $summary,
        ]);
    }
}
