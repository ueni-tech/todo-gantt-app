<?php

namespace Tests\Feature;

use App\Http\Middleware\Authenticate;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

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

        $response = $this->post('/projects', ['name' => 'プロジェクト']);
        $response->assertRedirect();
        $this->assertDatabaseHas('projects', ['name' => 'プロジェクト', 'team_id' => $team->id, 'user_id' => $user->id]);
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

        $response = $this->post('/projects', ['name' => '']);
        $response->assertSessionHasErrors('name');
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

        $response = $this->post('/projects', ['name' => str_repeat('a', 256)]);
        $response->assertSessionHasErrors('name');
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

        $response = $this->patch("/projects/{$project->id}", ['name' => 'プロジェクト2']);
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
}
