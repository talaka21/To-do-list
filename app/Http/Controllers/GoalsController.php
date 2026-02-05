<?php

namespace App\Http\Controllers;

use App\Models\goals;
use App\Http\Requests\StoregoalsRequest;
use App\Http\Requests\UpdategoalsRequest;
use App\Services\GoalService;
use App\Models\Goal;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class GoalsController extends Controller
{
    protected $goalService;

    public function __construct(GoalService $goalService)
    {
        $this->goalService = $goalService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json(['data' => $this->goalService->getAllGoals()]);
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
    public function store(StoregoalsRequest $request): JsonResponse
    {
        $goal = $this->goalService->createGoal($request->validated());
        return response()->json(['message' => 'Created', 'data' => $goal], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Goal $goals, $id)
    {
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
    public function update(StoregoalsRequest $request, $id)
    {
        $goal = $this->goalService->updateGoal($id, $request->validated());
        return response()->json(['message' => 'Updated', 'data' => $goal]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse {
        $this->goalService->deleteGoal($id);
        return response()->json(['message' => 'Deleted']);
    }
}
