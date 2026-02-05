<?php

namespace App\Http\Controllers;

use App\Models\goals;
use App\Http\Requests\StoregoalsRequest;
use App\Http\Requests\UpdategoalsRequest;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;

class GoalsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $goals = auth::user()->goals()->withCount('tasks')->get();
        return response()->json(['status' => 'success', 'data' => $goals]);
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
    public function store(StoregoalsRequest $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed'
        ]);
$goal = Auth::user()->goals()->create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Goal created successfully',
            'data' => $goal
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Goal $goals,$id) {
        $goal = Auth::user()->goals()->with('tasks')->findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $goal
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Goal $goals)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdategoalsRequest $request, $id) {
$goal = Auth::user()->goals()->findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|required|in:pending,in_progress,completed',
        ]);

        $goal->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Goal updated successfully',
            'data' => $goal
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Goal $goals,$id) {
        $goal = Auth::user()->goals()->findOrFail($id);

        $goal->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Goal deleted successfully'
        ]);
    }
}
