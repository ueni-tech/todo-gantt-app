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

    /**
     * @test
     */
    public function teams_store()
    {
        $this->withoutMiddleware(Authenticate::class);
        $this->post('/teams', ['team_name' => ' 犬チーム_123 ']);
        $this->assertDatabaseHas('teams', ['name' => '犬チーム_123']);
    }

    /**
     * @test
     */
    public function teams_store_bind_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->post('/teams', ['team_name' => '犬チーム']);
        $this->assertDatabaseHas('teams', ['name' => '犬チーム']);
        $team = Team::where('name', '犬チーム')->first();
        $this->assertDatabaseHas('team_user', ['team_id' => $team->id, 'user_id' => $user->id]);
    }

    /**
     * @test
     */
    public function teams_store_selected_team()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $this->post('/teams', ['team_name' => '犬チーム']);
        $this->assertDatabaseHas('teams', ['name' => '犬チーム']);
        $team = Team::where('name', '犬チーム')->first();
        $this->assertDatabaseHas('users', ['id' => $user->id, 'selected_team_id' => $team->id]);
    }

    /**
     * @test
     */
    public function teams_store_name_length_256()
    {
        $this->withoutMiddleware(Authenticate::class);
        $response = $this->post('/teams', ['team_name' => str_repeat('あ', 256)]);
        $response->assertSessionHasErrors(['team_name']);
    }

    /**
     * @test
     */
    public function teams_store_validation_error()
    {
        $this->withoutMiddleware(Authenticate::class);
        $response = $this->post('/teams', ['team_name' => ' ']);
        $response->assertSessionHasErrors(['team_name']);
    }

    /**
     * @test
     */
    public function teams_store_unique_error()
    {
        $this->withoutMiddleware(Authenticate::class);
        $team = Team::factory()->create(['name' => '犬チーム']);
        $response = $this->post('/teams', ['team_name' => '犬チーム']);
        $response->assertSessionHasErrors(['team_name']);
    }

    /**
     * @test
     */
    public function teams_update()
    {
        $this->withoutMiddleware(Authenticate::class);
        $team = Team::factory()->create();
        $this->patch("/teams/{$team->id}", ['team_name' => '猫チーム']);
        $this->assertDatabaseHas('teams', ['id' => $team->id, 'name' => '猫チーム']);
    }

    /**
     * @test
     */
    public function teams_update_name_length_256()
    {
        $this->withoutMiddleware(Authenticate::class);
        $team = Team::factory()->create();
        $response = $this->patch("/teams/{$team->id}", ['team_name' => str_repeat('あ', 256)]);
        $response->assertSessionHasErrors(['team_name']);
    }

    /**
     * @test
     */
    public function teams_update_validation_error()
    {
        $this->withoutMiddleware(Authenticate::class);
        $team = Team::factory()->create();
        $response = $this->patch("/teams/{$team->id}", ['team_name' => ' ']);
        $response->assertSessionHasErrors(['team_name']);
    }

    /**
     * @test
     */
    public function teams_update_unique_error()
    {
        $this->withoutMiddleware(Authenticate::class);
        $team1 = Team::factory()->create(['name' => '犬チーム']);
        $team2 = Team::factory()->create(['name' => '猫チーム']);
        $response = $this->patch("/teams/{$team1->id}", ['team_name' => '猫チーム']);
        $response->assertSessionHasErrors(['team_name']);
    }

    /**
     * @test
     */
    public function teams_destroy()
    {
        $this->withoutMiddleware(Authenticate::class);
        $team = Team::factory()->create();
        $this->delete("/teams/{$team->id}");
        $this->assertDatabaseMissing('teams', ['id' => $team->id]);
    }
}
