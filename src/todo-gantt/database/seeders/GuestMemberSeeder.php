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
        $currentDate = Carbon::now();
        $guestTeam = Team::where('name', 'ゲストチーム')->first();

        // Aさんの作成
        User::updateOrCreate(
            ['email' => 'guestmember@example.com'],
            [
                'name' => 'Aさん',
                'password' => Hash::make('guestmember'),
                'provider' => 'guest',
                'provider_id' => 'guest'
            ]
        );

        $memberUserA = User::where('name', 'Aさん')->first();
        
        // 既存の関連付けを確認してから追加
        if (!$memberUserA->teams->contains($guestTeam->id)) {
            $memberUserA->teams()->attach($guestTeam->id);
        }
        $memberUserA->selected_team_id = $guestTeam->id;
        $memberUserA->save();

        // Aさんのプロジェクトとタスクを作成
        $projectA = Project::create([
            'name' => 'Aさんのプロジェクト',
            'team_id' => $guestTeam->id,
            'user_id' => $memberUserA->id,
            'status_name' => 'incomplete',
        ]);

        for ($i = 1; $i <= 3; $i++) {
            $startDate = $currentDate->copy()->addDays(($i - 1) * 4);
            $endDate = $startDate->copy()->addDays(3);

            Task::create([
                'name' => "Aさんのタスク{$i}",
                'project_id' => $projectA->id,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'completed' => 0,
            ]);
        }

        // Bさんの作成
        User::updateOrCreate(
            ['email' => 'guestmemberb@example.com'],
            [
                'name' => 'Bさん',
                'password' => Hash::make('guestmember'),
                'provider' => 'guest',
                'provider_id' => 'guest'
            ]
        );

        $memberUserB = User::where('name', 'Bさん')->first();
        
        // 既存の関連付けを確認してから追加
        if (!$memberUserB->teams->contains($guestTeam->id)) {
            $memberUserB->teams()->attach($guestTeam->id);
        }
        $memberUserB->selected_team_id = $guestTeam->id;
        $memberUserB->save();

        // Bさんのプロジェクトとタスクを作成
        $projectB = Project::create([
            'name' => 'Bさんのプロジェクト',
            'team_id' => $guestTeam->id,
            'user_id' => $memberUserB->id,
            'status_name' => 'incomplete',
        ]);

        for ($i = 1; $i <= 3; $i++) {
            $startDate = $currentDate->copy()->addDays(($i - 1) * 4 + 12); // Aさんのタスクの後に配置
            $endDate = $startDate->copy()->addDays(3);

            Task::create([
                'name' => "Bさんのタスク{$i}",
                'project_id' => $projectB->id,
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'completed' => 0,
            ]);
        }
    }
}
