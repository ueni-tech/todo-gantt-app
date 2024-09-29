<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuestMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'guestmember@example.com'],
            [
                'name' => 'Aさん',
                'password' => Hash::make('guestmember'),
                'provider' => 'guest',
                'provider_id' => 'guest'
            ]
        );

        $memberUser = User::where('name', 'Aさん')->first();
        $memberTeam = Team::where('name', 'ゲストチーム')->first();
        $memberUser->teams()->attach($memberTeam->id);
        $memberUser->selected_team_id = $memberTeam->id;
        $memberUser->save();


        // 現在の現在の日付を起点して、1つのプロジェクトとそれに紐づく3つのタスクを作成
        $currentDate = Carbon::now();

        $project = Project::create([
            'name' => ' Aさんのプロジェクト',
            'team_id' => 1,
            'user_id' => $memberUser->id,
            'status_name' => 'incomplete',
        ]);

        for ($i = 1; $i <= 3; $i++) {
            $startDate = $currentDate->copy()->addDays(($i + 2) * 4);
            $endDate = $startDate->copy()->addDays(3);

            Task::create([
                'name' => "Aさんのタスク{$i}",
                'project_id' => $project->id,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'completed' => 0,
            ]);
        }
    }
}
