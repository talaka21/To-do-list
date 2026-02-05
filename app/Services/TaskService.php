<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;

class TaskService
{

    public function createTask(int $goalId, array $data)
    {
        $goal = Auth::user()->goals()->findOrFail($goalId);

        return $goal->tasks()->create([
            'title' => $data['title'],
            'is_completed' => $data['is_completed'] ?? false
        ]);
    }


    public function updateTask(int $taskId, array $data)
    {
        $task = Task::whereHas('goal', function ($q) {
            $q->where('user_id', Auth::id());
        })->findOrFail($taskId);

        $task->update($data);
        return $task;
    }

    
    public function deleteTask(int $taskId)
    {
        $task = Task::whereHas('goal', function ($q) {
            $q->where('user_id', Auth::id());
        })->findOrFail($taskId);

        return $task->delete();
    }
}
