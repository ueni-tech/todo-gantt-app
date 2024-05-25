<?php

namespace Tests\Feature;

use App\Http\Middleware\Authenticate;
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
}
