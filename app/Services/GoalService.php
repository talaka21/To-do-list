<?php
namespace App\Services;

use App\Models\Goal;
use Illuminate\Support\Facades\Auth;

class GoalService
{
    public function getAllGoals() {
        return Auth::user()->goals()->withCount('tasks')->get();
    }

    public function createGoal(array $data) {
        return Auth::user()->goals()->create($data);
    }

    public function updateGoal($id, array $data) {
        $goal = Auth::user()->goals()->findOrFail($id);
        $goal->update($data);
        return $goal;
    }

    public function deleteGoal($id) {
        $goal = Auth::user()->goals()->findOrFail($id);
        return $goal->delete();
    }
}
