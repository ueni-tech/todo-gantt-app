<?php

namespace Tests\Feature;

use App\Livewire\Modals\TeamEdit;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class RemoveUserFromTeamTest extends TestCase
{
    use RefreshDatabase;

    /**
     *  
     * @test
     * 
     * */
    public function removes_user_from_team()
    {
        $team = Team::factory()->create();
        $user = User::factory()->create();
        $this->actingAs($user);

        $team->users()->attach($user);

        Livewire::test(TeamEdit::class, ['selectedTeam' => $team])
            ->call('removeUserFromTeam', $user->id);

        $this->assertDatabaseMissing('team_user', [
            'team_id' => $team->id,
            'user_id' => $user->id,
        ]);

        $this->assertNull($user->fresh()->selected_team_id);

        $this->assertDatabaseMissing('teams', ['id' => $team->id]);
    }
}
