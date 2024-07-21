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

  protected $user;
  protected $team;

  protected function setUp(): void
  {
    parent::setUp();
    $this->seed('ProjectStatusSeeder');
    $this->setUpUserAndTeam();
  }

  protected function setUpUserAndTeam()
  {
    $this->user = User::factory()->create();
    $this->team = Team::factory()->create();
    $this->team->users()->attach($this->user);
    $this->user->selected_team_id = $this->team->id;
    $this->actingAs($this->user);
  }

  /**
   * @test
   */
  public function a_user_can_create_project()
  {
    $incompleteStatus_id = ProjectStatus::where('name', 'incomplete')->first()->id;

    $response = $this->post('/projects', ['project_name' => 'プロジェクト']);
    $response->assertRedirect();
    $this->assertDatabaseHas('projects', ['name' => 'プロジェクト', 'team_id' => $this->team->id, 'user_id' => $this->user->id, 'status_id' => $incompleteStatus_id]);
  }

  /**
   * @test
   */
  public function a_user_can_not_create_project_without_name()
  {
    $response = $this->post('/projects', ['project_name' => '']);
    $response->assertSessionHasErrors('project_name');
  }

  /**
   * @test
   */
  public function a_user_can_not_create_project_with_name_length_over_255()
  {
    $response = $this->post('/projects', ['project_name' => str_repeat('a', 256)]);
    $response->assertSessionHasErrors('project_name');
  }

  /**
   * @test
   */
  public function createProjectのテスト()
  {
    $project = Project::createProject($this->user, $this->team, 'プロジェクト');
    $this->assertDatabaseHas('projects', ['name' => 'プロジェクト', 'team_id' => $this->team->id, 'user_id' => $this->user->id]);
  }

  /**
   * @test
   */
  public function updateNameのテスト()
  {
    $project = Project::createProject($this->user, $this->team, 'プロジェクト');

    $project = Project::updateName('プロジェクト2', $project);
    $this->assertEquals('プロジェクト2', $project->name);
  }

  /**
   * @test
   */
  public function a_user_can_update_project()
  {
    $project = Project::createProject($this->user, $this->team, 'プロジェクト');

    $response = $this->patch("/projects/{$project->id}", ['project_name' => 'プロジェクト2']);
    $response->assertRedirect();
    $this->assertDatabaseHas('projects', ['name' => 'プロジェクト2', 'team_id' => $this->team->id, 'user_id' => $this->user->id]);
  }

  /**
   * @test
   */
  public function a_user_can_not_update_project_without_name()
  {
    $project = Project::createProject($this->user, $this->team, 'プロジェクト');

    $response = $this->patch("/projects/{$project->id}", ['name' => '']);
    $response->assertSessionHasErrors();
  }

  /**
   * @test
   */
  public function a_user_can_not_update_project_with_name_length_over_255()
  {
    $project = Project::createProject($this->user, $this->team, 'プロジェクト');

    $response = $this->patch("/projects/{$project->id}", ['name' => str_repeat('a', 256)]);
    $response->assertSessionHasErrors();
  }

  /**
   * @test
   */
  public function a_user_can_delete_project()
  {
    $project = Project::createProject($this->user, $this->team, 'プロジェクト');

    $response = $this->delete("/projects/{$project->id}");
    $response->assertRedirect();
    $this->assertDatabaseMissing('projects', ['name' => 'プロジェクト', 'team_id' => $this->team->id, 'user_id' => $this->user->id]);
  }

  /**
   * @test
   */
  public function project_statusをcompletedに更新するテスト()
  {
    $project = Project::createProject($this->user, $this->team, 'プロジェクト');

    $completedStatus_id = ProjectStatus::where('name', 'completed')->first()->id;
    $response = $this->patch("/projects/{$project->id}/update-status", ['status' => 'completed']);
    $response->assertRedirect();
    $this->assertDatabaseHas('projects', [
      'name' => 'プロジェクト',
      'team_id' => $this->team->id,
      'user_id' => $this->user->id,
      'status_id' => $completedStatus_id
    ]);
  }

  /**
   * @test
   */
  public function project_statusをincompleteに更新するテスト()
  {
    $project = Project::createProject($this->user, $this->team, 'プロジェクト');

    $incompleteStatus_id = ProjectStatus::where('name', 'incomplete')->first()->id;
    $response = $this->patch("/projects/{$project->id}/update-status", ['status' => 'incomplete']);
    $response->assertRedirect();
    $this->assertDatabaseHas('projects', [
      'name' => 'プロジェクト',
      'team_id' => $this->team->id,
      'user_id' => $this->user->id,
      'status_id' => $incompleteStatus_id
    ]);
  }

  /**
   * @test
   */
  public function project_statusをpendingに更新するテスト()
  {
    $project = Project::createProject($this->user, $this->team, 'プロジェクト');

    $pendingStatus_id = ProjectStatus::where('name', 'pending')->first()->id;
    $response = $this->patch("/projects/{$project->id}/update-status", ['status' => 'pending']);
    $response->assertRedirect();
    $this->assertDatabaseHas('projects', [
      'name' => 'プロジェクト',
      'team_id' => $this->team->id,
      'user_id' => $this->user->id,
      'status_id' => $pendingStatus_id
    ]);
  }
}
