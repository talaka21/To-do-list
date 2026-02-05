<?php
namespace App\Http\Controllers;

use App\Services\TaskService;
use App\Http\Requests\TaskStoreRequest;
use Illuminate\Http\JsonResponse;

class TasksController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }


    public function store( TaskStoreRequest $request, $goalId): JsonResponse
    {
        $task = $this->taskService->createTask($goalId, $request->validated());
        return response()->json($task, 201);
    }


    public function update( TaskStoreRequest $request, $id): JsonResponse
    {
        $task = $this->taskService->updateTask($id, $request->validated());
        return response()->json($task);
    }


    public function destroy($id): JsonResponse
    {
        $this->taskService->deleteTask($id);
        return response()->json(['message' => 'Task deleted']);
    }
}
