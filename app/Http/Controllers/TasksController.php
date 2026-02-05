<?php

namespace App\Http\Controllers;

use App\Models\tasks;
use App\Models\Task;
use App\Models\Goal;
use Illuminate\Http\Request;
use App\Http\Requests\StoretasksRequest;
use App\Http\Requests\UpdatetasksRequest;
use Illuminate\Support\Facades\Redirect;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::all();
        return response()->json($tasks, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoretasksRequest $request, $goalId)
    {
        $gole = $request->user->goals()->findOrFail($goalId);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $task =  $gole->tasks()->create([
            'title' => $validated['title'],
            'is_completed'
        ]);
        return response()->json($task, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $tasks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $tasks)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatetasksRequest $request, $id)
    {

        $task = Task::whereHas('goal', function ($q) use ($request) {
            $q->where('user_id', $request->user()->id);
        })->findOrFail($id);

        $task->update($request->only(['title', 'is_completed']));

        return response()->json($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $tasks, Request $request, $id)
    {
        $task = Task::whereHas('goal', function ($q) use ($request) {
            $q->where('user_id', $request->user()->id);
        })->findOrFail($id);

        $task->delete();

        return response()->json(['message' => 'Task deleted']);
    }
}
