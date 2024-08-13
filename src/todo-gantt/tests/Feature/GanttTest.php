<?php

namespace Tests\Feature;

use App\Models\Gantt;
use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class GanttTest extends TestCase
{
    use RefreshDatabase;

    protected $user1;
    protected $user2;
    protected $team;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed('ProjectStatusSeeder');
        $this->setUpUserAndTeam();
    }

    protected function setUpUserAndTeam()
    {
        $this->user1 = User::factory()->create();
        $this->user2 = User::factory()->create();
        $this->team = Team::factory()->create();
        $this->team->users()->attach($this->user1);
        $this->team->users()->attach($this->user2);
        $this->user1->selected_team_id = $this->team->id;
        $this->user2->selected_team_id = $this->team->id;
        $this->actingAs($this->user1);
    }

    /**
     * @test
     */
    public function ガントチャート用のデータ取得のテスト(): void
    {
        $project1 = Project::factory()->create([
            'team_id' => $this->team->id,
            'user_id' => $this->user1->id,
            'status_name' => 'incomplete',
        ]);

        $project2 = Project::factory()->create([
            'team_id' => $this->team->id,
            'user_id' => $this->user2->id,
            'status_name' => 'incomplete',
        ]);

        Task::createTask($project1, 'タスク1', 'メモ1', '2021-01-01', '2021-01-02');
        Task::createTask($project2, 'タスク2', 'メモ2', '2021-02-02', '2021-02-22');

        $ganttData = Gantt::getGanttData($this->user1);

        $this->assertEquals(2, count($ganttData));

        $this->assertEquals('タスク1', $ganttData[0]['tasks'][0]['name']);
        $this->assertEquals('2021-01-01', $ganttData[0]['tasks'][0]['start_date']);
        $this->assertEquals('2021-01-02', $ganttData[0]['tasks'][0]['end_date']);

        $this->assertEquals('タスク2', $ganttData[1]['tasks'][0]['name']);
        $this->assertEquals('2021-02-02', $ganttData[1]['tasks'][0]['start_date']);
        $this->assertEquals('2021-02-22', $ganttData[1]['tasks'][0]['end_date']);
    }

    /**
     * @test
     */
    public function api_ganttルートのテスト(): void
    {
        $project1 = Project::factory()->create([
            'team_id' => $this->team->id,
            'user_id' => $this->user1->id,
            'status_name' => 'incomplete',
        ]);

        $project2 = Project::factory()->create([
            'team_id' => $this->team->id,
            'user_id' => $this->user2->id,
            'status_name' => 'incomplete',
        ]);

        Task::createTask($project1, 'タスク1', 'メモ1', '2021-01-01', '2021-01-02');
        Task::createTask($project2, 'タスク2', 'メモ2', '2021-02-02', '2021-02-22');

        $response = $this->get('/api/gantt');

        $response->assertStatus(200);
        $response->assertJsonCount(2);
    }
}
