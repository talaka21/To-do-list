<?php

namespace Tests\Feature;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_user_can_create_task_under_their_goal()
{
 
    $user = User::factory()->create();
    $goal = Goal::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);
    $data = ['title' => 'Task #urgent today'];
    $response = $this->postJson("/api/goals/{$goal->id}/tasks", $data);
    $response->assertStatus(201);
    $this->assertDatabaseHas('tasks', [
        'goal_id' => $goal->id,
        'title'   => 'Task #urgent today'
    ]);
}

public function test_it_fails_if_title_is_missing()
{
    $user = User::factory()->create();
    $goal = Goal::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user);
    $response = $this->postJson("/api/goals/{$goal->id}/tasks", []);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['title']);
}


public function test_user_cannot_add_task_to_another_user_goal()
{
    $hacker = User::factory()->create();
    $victim = User::factory()->create();
    $victimGoal = Goal::factory()->create(['user_id' => $victim->id]);
    $this->actingAs($hacker);
    $response = $this->postJson("/api/goals/{$victimGoal->id}/tasks", [
        'title' => 'I am stealing your time!'
    ]);

    $response->assertStatus(404);
    $this->assertDatabaseMissing('tasks', ['title' => 'I am stealing your time!']);
}
}
