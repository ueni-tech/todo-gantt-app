<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function createTaskのテスト()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $team = Team::factory()->create();
        $team->users()->attach($user);
        $user->selected_team_id = $team->id;

        $project = Project::createProject($user, $team, 'プロジェクト');

        $name = 'タスク';
        $note = 'メモ';
        $start_date = '2021-01-01';
        $end_date = '2021-01-31';

        $task = Task::createTask($project, $name, $note, $start_date, $end_date);

        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'name' => $name,
            'note' => $note,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'completed' => 0,
        ]);
    }

    /**
     * @test
     */
    public function a_user_can_create_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $team = Team::factory()->create();
        $team->users()->attach($user);
        $user->selected_team_id = $team->id;

        $project = Project::createProject($user, $team, 'プロジェクト');

        $response = $this->post('/tasks', [
            'project_id' => $project->id,
            'name' => 'タスク',
            'note' => 'メモ',
            'start_date' => '2021-01-01',
            'end_date' => '2021-01-31',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'name' => 'タスク',
            'note' => 'メモ',
            'start_date' => '2021-01-01',
            'end_date' => '2021-01-31',
            'completed' => 0,
        ]);
    }

    /**
     * @test
     */
    public function updateTaskのテスト()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $team = Team::factory()->create();
        $team->users()->attach($user);
        $user->selected_team_id = $team->id;

        $project = Project::createProject($user, $team, 'プロジェクト');

        $task = Task::createTask($project, 'タスク', 'メモ', '2021-01-01', '2021-01-31');

        $name = 'タスク2';
        $note = 'メモ2';
        $start_date = '2021-02-01';
        $end_date = '2021-02-28';

        $task = Task::updateTask($task, $name, $note, $start_date, $end_date);

        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'name' => $name,
            'note' => $note,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'completed' => 0,
        ]);
    }

    /**
     * @test
     */
    public function a_user_can_update_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $team = Team::factory()->create();
        $team->users()->attach($user);
        $user->selected_team_id = $team->id;

        $project = Project::createProject($user, $team, 'プロジェクト');

        $task = Task::createTask($project, 'タスク', 'メモ', '2021-01-01', '2021-01-31');

        $response = $this->patch('/tasks/' . $task->id, [
            'name' => 'タスク2',
            'note' => 'メモ2',
            'start_date' => '2021-02-01',
            'end_date' => '2021-02-28',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'name' => 'タスク2',
            'note' => 'メモ2',
            'start_date' => '2021-02-01',
            'end_date' => '2021-02-28',
            'completed' => 0,
        ]);
    }

    /**
     * @test
     */
    public function toggleCompletedのテスト()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $team = Team::factory()->create();
        $team->users()->attach($user);
        $user->selected_team_id = $team->id;

        $project = Project::createProject($user, $team, 'プロジェクト');

        $task = Task::createTask($project, 'タスク', 'メモ', '2021-01-01', '2021-01-31');

        $task = Task::toggleCompleted($task);

        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'name' => 'タスク',
            'note' => 'メモ',
            'start_date' => '2021-01-01',
            'end_date' => '2021-01-31',
            'completed' => 1,
        ]);

        $task = Task::toggleCompleted($task);

        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'name' => 'タスク',
            'note' => 'メモ',
            'start_date' => '2021-01-01',
            'end_date' => '2021-01-31',
            'completed' => 0,
        ]);
    }

    /**
     * @test
     */
    public function a_user_can_toggle_task()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $team = Team::factory()->create();
        $team->users()->attach($user);
        $user->selected_team_id = $team->id;

        $project = Project::createProject($user, $team, 'プロジェクト');

        $task = Task::createTask($project, 'タスク', 'メモ', '2021-01-01', '2021-01-31');

        $response = $this->get('/tasks/' . $task->id . '/toggle');

        $response->assertRedirect();

        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'name' => 'タスク',
            'note' => 'メモ',
            'start_date' => '2021-01-01',
            'end_date' => '2021-01-31',
            'completed' => 1,
        ]);

        $response = $this->get('/tasks/' . $task->id . '/toggle');

        $response->assertRedirect();

        $this->assertDatabaseHas('tasks', [
            'project_id' => $project->id,
            'name' => 'タスク',
            'note' => 'メモ',
            'start_date' => '2021-01-01',
            'end_date' => '2021-01-31',
            'completed' => 0,
        ]);
    }
}
