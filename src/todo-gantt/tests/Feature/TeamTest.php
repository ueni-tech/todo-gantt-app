<?php

namespace Tests\Feature;

use App\Http\Middleware\Authenticate;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_teams_index()
    {
        $this->withoutMiddleware(Authenticate::class);
        $response = $this->get('/teams');
        $response->assertStatus(200);
    }

    public function test_teams_store()
    {
        $this->withoutMiddleware(Authenticate::class);
        //ユーザーを作成
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->post('/teams', ['name' => 'Team 1']);
        $response->assertRedirect(route('index'));
        $this->assertDatabaseHas('teams', ['name' => 'Team 1']);

        $team = Team::first();
        $this->assertDatabaseHas('team_user', ['team_id' => $team->id, 'user_id' => $user->id]);
    }
}
