<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuestUserSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'guest@example.com'],
            [
                'name' => 'guestuser',
                'password' => Hash::make('guestpass0406'),
                'provider' => 'guest',
                'provider_id' => 'guest'
            ]
        );

        Team::create([
            'name' => 'ゲストチーム',
        ]);

        $guestUser = User::where('name', 'guestuser')->first();
        $guestTeam = Team::where('name', 'ゲストチーム')->first();
        $guestUser->teams()->attach($guestTeam->id);
        $guestUser->selected_team_id = $guestTeam->id;
        $guestUser->save();

        Project::create([
            'name' => 'ゲストプロジェクト1',
            'team_id' => 1,
            'user_id' => 1,
            'status_name' => 'incomplete',
        ]);

        Project::create([
            'name' => 'ゲストプロジェクト2',
            'team_id' => 1,
            'user_id' => 1,
            'status_name' => 'incomplete',
        ]);

        Project::create([
            'name' => 'ゲストプロジェクト3',
            'team_id' => 1,
            'user_id' => 1,
            'status_name' => 'incomplete',
        ]);

        Project::create([
            'name' => 'ゲストプロジェクト4',
            'team_id' => 1,
            'user_id' => 1,
            'status_name' => 'pending',
        ]);

        Project::create([
            'name' => 'ゲストプロジェクト5',
            'team_id' => 1,
            'user_id' => 1,
            'status_name' => 'completed',
        ]);



        Task::create([
            'name' => 'ゲストタスク1',
            'project_id' => 1,
            'start_date' => '2024-09-05',
            'end_date' => '2024-09-08',
            'completed' => 0,
        ]);

        Task::create([
            'name' => 'ゲストタスク2',
            'project_id' => 1,
            'start_date' => '2024-09-09',
            'end_date' => '2024-09-12',
            'completed' => 0,
        ]);

        Task::create([
            'name' => 'ゲストタスク3',
            'project_id' => 1,
            'start_date' => '2024-09-13',
            'end_date' => '2024-09-16',
            'completed' => 0,
        ]);

        Task::create([
            'name' => 'ゲストタスク4',
            'project_id' => 2,
            'start_date' => '2024-09-05',
            'end_date' => '2024-09-08',
            'completed' => 0,
        ]);

        Task::create([
            'name' => 'ゲストタスク5',
            'project_id' => 2,
            'start_date' => '2024-09-09',
            'end_date' => '2024-09-12',
            'completed' => 0,
        ]);

        Task::create([
            'name' => 'ゲストタスク6',
            'project_id' => 2,
            'start_date' => '2024-09-13',
            'end_date' => '2024-09-16',
            'completed' => 0,
        ]);

        Task::create([
            'name' => 'ゲストタスク7',
            'project_id' => 3,
            'start_date' => '2024-09-05',
            'end_date' => '2024-09-08',
            'completed' => 0,
        ]);

        Task::create([
            'name' => 'ゲストタスク8',
            'project_id' => 3,
            'start_date' => '2024-09-09',
            'end_date' => '2024-09-12',
            'completed' => 0,
        ]);

        Task::create([
            'name' => 'ゲストタスク9',
            'project_id' => 3,
            'start_date' => '2024-09-13',
            'end_date' => '2024-09-16',
            'completed' => 0,
        ]);

        Task::create([
            'name' => 'ゲストタスク10',
            'project_id' => 4,
            'start_date' => '2024-09-05',
            'end_date' => '2024-09-08',
            'completed' => 0,
        ]);

        Task::create([
            'name' => 'ゲストタスク11',
            'project_id' => 5,
            'start_date' => '2024-09-09',
            'end_date' => '2024-09-12',
            'completed' => 0,
        ]);
    }
}
