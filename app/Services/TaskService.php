<?php

namespace App\Services;

use App\Models\Task;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TaskService
{

    public function createTask(int $goalId, array $data)
    {
        $goal = Auth::user()->goals()->findOrFail($goalId);

        $parsedData = $this->parseTaskTitle($data['title']);

        return $goal->tasks()->create([
            'title' => $data['title'],
            'is_completed' => $data['is_completed'] ?? false
        ]);
    }

    private function parseTaskTitle(string $title): array
    {
        $priority = 'medium';
        $dueDate = null;

        if (str_contains(strtolower($title), '#urgent') || str_contains(strtolower($title), 'بسرعة')) {
            $priority = 'high';
            $title = str_replace(['#urgent', 'بسرعة'], '', $title);
        }

        $keywords = ['tomorrow', 'next', 'after', 'today', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        foreach ($keywords as $word) {
            if (str_contains(strtolower($title), $word)) {
                try {
                    $dueDate = Carbon::parse($word)->startOfHour();
                    break;
                } catch (\Exception $e) {
                    $dueDate = null;
                }
            }
        }

        return [
            'clean_title' => trim($title),
            'due_date'    => $dueDate,
            'priority'    => $priority,
        ];
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
