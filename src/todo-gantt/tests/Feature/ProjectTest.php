<?php

namespace Tests\Feature;

use App\Http\Middleware\Authenticate;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
  use RefreshDatabase;

  protected function setUp(): void
  {
    parent::setUp();
    $this->seed('ProjectStatusSeeder');
  }

  /**
   * @test
   */
  public function a_user_can_create_project()
  {
    $user = User::factory()->create();
    $this->actingAs($user);
    $team = Team::factory()->create();
    $team->users()->attach($user);
    $user->selected_team_id = $team->id;

    $incompleteStatus_id = ProjectStatus::where('name', 'incomplete')->first()->id;

    $response = $this->post('/projects', ['project_name' => 'プロジェクト']);
    $response->assertRedirect();
    $this->assertDatabaseHas('projects', ['name' => 'プロジェクト', 'team_id' => $team->id, 'user_id' => $user->id, 'status_id' => $incompleteStatus_id]);
  }

  /**
   * @test
   */
  public function a_user_can_not_create_project_without_name()
  {
    $user = User::factory()->create();
    $this->actingAs($user);
    $team = Team::factory()->create();
    $team->users()->attach($user);
    $user->selected_team_id = $team->id;

    $response = $this->post('/projects', ['project_name' => '']);
    $response->assertSessionHasErrors('project_name');
  }

  /**
   * @test
   */
  public function a_user_can_not_create_project_without_name_length_over_255()
  {
    $user = User::factory()->create();
    $this->actingAs($user);
    $team = Team::factory()->create();
    $team->users()->attach($user);
    $user->selected_team_id = $team->id;

    $response = $this->post('/projects', ['project_name' => str_repeat('a', 256)]);
    $response->assertSessionHasErrors('project_name');
  }

  /**
   * @test
   */
  public function createProjectのテスト()
  {
    $user = User::factory()->create();
    $team = Team::factory()->create();
    $team->users()->attach($user);
    $user->selected_team_id = $team->id;

    $project = Project::createProject($user, $team, 'プロジェクト');
    $this->assertDatabaseHas('projects', ['name' => 'プロジェクト', 'team_id' => $team->id, 'user_id' => $user->id]);
  }

  /**
   * @test
   */
  public function updateNameのテスト()
  {
    $user = User::factory()->create();
    $team = Team::factory()->create();
    $team->users()->attach($user);
    $user->selected_team_id = $team->id;
    $project = Project::createProject($user, $team, 'プロジェクト');

    $project = Project::updateName('プロジェクト2', $project);
    $this->assertEquals('プロジェクト2', $project->name);
  }

  /**
   * @test
   */
  public function a_user_can_update_project()
  {
    $user = User::factory()->create();
    $this->actingAs($user);
    $team = Team::factory()->create();
    $team->users()->attach($user);
    $user->selected_team_id = $team->id;
    $project = $team->projects()->create(['name' => 'プロジェクト', 'user_id' => $user->id]);

    $response = $this->patch("/projects/{$project->id}", ['project_name' => 'プロジェクト2']);
    $response->assertRedirect();
    $this->assertDatabaseHas('projects', ['name' => 'プロジェクト2', 'team_id' => $team->id, 'user_id' => $user->id]);
  }

  /**
   * @test
   */
  public function a_user_can_not_update_project_without_name()
  {
    $user = User::factory()->create();
    $this->actingAs($user);
    $team = Team::factory()->create();
    $team->users()->attach($user);
    $user->selected_team_id = $team->id;
    $project = $team->projects()->create(['name' => 'プロジェクト', 'user_id' => $user->id]);

    $response = $this->patch("/projects/{$project->id}", ['name' => '']);
    $response->assertSessionHasErrors();
  }

  /**
   * @test
   */
  public function a_user_can_not_update_project_without_name_length_over_255()
  {
    $user = User::factory()->create();
    $this->actingAs($user);
    $team = Team::factory()->create();
    $team->users()->attach($user);
    $user->selected_team_id = $team->id;
    $project = $team->projects()->create(['name' => 'プロジェクト', 'user_id' => $user->id]);

    $response = $this->patch("/projects/{$project->id}", ['name' => str_repeat('a', 256)]);
    $response->assertSessionHasErrors();
  }

  /**
   * @test
   */
  public function a_user_can_delete_project()
  {
    $user = User::factory()->create();
    $this->actingAs($user);
    $team = Team::factory()->create();
    $team->users()->attach($user);
    $user->selected_team_id = $team->id;
    $project = $team->projects()->create(['name' => 'プロジェクト', 'user_id' => $user->id]);

    $response = $this->delete("/projects/{$project->id}");
    $response->assertRedirect();
    $this->assertDatabaseMissing('projects', ['name' => 'プロジェクト', 'team_id' => $team->id, 'user_id' => $user->id]);
  }

  /**
   * @test
   */
  public function updateStatusのテスト()
  {
    $user = User::factory()->create();
    $team = Team::factory()->create();
    $this->actingAs($user);
    $team->users()->attach($user);
    $user->selected_team_id = $team->id;
    $project = Project::createProject($user, $team, 'プロジェクト');

    // 各ステータスのidを取得
    $incompleteStatus_id = ProjectStatus::where('name', 'incomplete')->first()->id;
    $completedStatus_id = ProjectStatus::where('name', 'completed')->first()->id;
    $pendingStatus_id = ProjectStatus::where('name', 'pending')->first()->id;

    // プロジェクトが作成されたときのステータスを確認
    $this->assertDatabaseHas('projects', [
      'name' => 'プロジェクト',
      'team_id' => $team->id,
      'user_id' => $user->id,
      'status_id' => $incompleteStatus_id
    ]);

    // ステータスを'completed'に更新
    $response = $this->patch("/projects/{$project->id}/update-status", ['status' => 'completed']);
    $response->assertRedirect();
    $this->assertDatabaseHas('projects', [
      'name' => 'プロジェクト',
      'team_id' => $team->id,
      'user_id' => $user->id,
      'status_id' => $completedStatus_id
    ]);

    // ステータスを'incomplete'に戻す
    $response = $this->patch("/projects/{$project->id}/update-status", ['status' => 'incomplete']);
    $response->assertRedirect();
    $this->assertDatabaseHas('projects', [
      'name' => 'プロジェクト',
      'team_id' => $team->id,
      'user_id' => $user->id,
      'status_id' => $incompleteStatus_id
    ]);

    // ステータスを'pending'に更新
    $response = $this->patch("/projects/{$project->id}/update-status", ['status' => 'pending']);
    $response->assertRedirect();
    $this->assertDatabaseHas('projects', [
      'name' => 'プロジェクト',
      'team_id' => $team->id,
      'user_id' => $user->id,
      'status_id' => $pendingStatus_id
    ]);
  }
}
