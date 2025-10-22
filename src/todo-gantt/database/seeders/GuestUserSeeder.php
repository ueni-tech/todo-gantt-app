<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
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

        Team::firstOrCreate([
            'name' => 'ゲストチーム',
        ]);

        $guestUser = User::where('name', 'guestuser')->first();
        $guestTeam = Team::where('name', 'ゲストチーム')->first();
        
        // 既存の関連付けを確認してから追加
        if (!$guestUser->teams->contains($guestTeam->id)) {
            $guestUser->teams()->attach($guestTeam->id);
        }
        $guestUser->selected_team_id = $guestTeam->id;
        $guestUser->save();

        // 現在の日付を取得
        $currentDate = Carbon::now();

        // プロジェクト1を作成
        $project1 = Project::create([
            'name' => 'ゲストプロジェクト1',
            'team_id' => $guestTeam->id,
            'user_id' => $guestUser->id,
            'status_name' => 'incomplete',
        ]);

        // プロジェクト2を作成
        $project2 = Project::create([
            'name' => 'ゲストプロジェクト2',
            'team_id' => $guestTeam->id,
            'user_id' => $guestUser->id,
            'status_name' => 'incomplete',
        ]);

        // プロジェクト3を作成
        $project3 = Project::create([
            'name' => 'ゲストプロジェクト3',
            'team_id' => $guestTeam->id,
            'user_id' => $guestUser->id,
            'status_name' => 'incomplete',
        ]);

        // プロジェクト4を作成
        $project4 = Project::create([
            'name' => 'ゲストプロジェクト4',
            'team_id' => $guestTeam->id,
            'user_id' => $guestUser->id,
            'status_name' => 'pending',
        ]);

        // プロジェクト5を作成
        $project5 = Project::create([
            'name' => 'ゲストプロジェクト5',
            'team_id' => $guestTeam->id,
            'user_id' => $guestUser->id,
            'status_name' => 'completed',
        ]);

        // タスクの日付を動的に生成
        // プロジェクト1のタスク
        Task::create([
            'name' => 'ゲストタスク1',
            'project_id' => $project1->id,
            'start_date' => $currentDate->copy()->format('Y-m-d'),
            'end_date' => $currentDate->copy()->addDays(3)->format('Y-m-d'),
            'completed' => 0,
        ]);

        Task::create([
            'name' => 'ゲストタスク2',
            'project_id' => $project1->id,
            'start_date' => $currentDate->copy()->addDays(4)->format('Y-m-d'),
            'end_date' => $currentDate->copy()->addDays(7)->format('Y-m-d'),
            'completed' => 0,
        ]);

        Task::create([
            'name' => 'ゲストタスク3',
            'project_id' => $project1->id,
            'start_date' => $currentDate->copy()->addDays(8)->format('Y-m-d'),
            'end_date' => $currentDate->copy()->addDays(11)->format('Y-m-d'),
            'completed' => 0,
        ]);

        // プロジェクト2のタスク
        Task::create([
            'name' => 'ゲストタスク4',
            'project_id' => $project2->id,
            'start_date' => $currentDate->copy()->addDays(12)->format('Y-m-d'),
            'end_date' => $currentDate->copy()->addDays(15)->format('Y-m-d'),
            'completed' => 0,
        ]);

        Task::create([
            'name' => 'ゲストタスク5',
            'project_id' => $project2->id,
            'start_date' => $currentDate->copy()->addDays(16)->format('Y-m-d'),
            'end_date' => $currentDate->copy()->addDays(19)->format('Y-m-d'),
            'completed' => 0,
        ]);

        Task::create([
            'name' => 'ゲストタスク6',
            'project_id' => $project2->id,
            'start_date' => $currentDate->copy()->addDays(20)->format('Y-m-d'),
            'end_date' => $currentDate->copy()->addDays(23)->format('Y-m-d'),
            'completed' => 0,
        ]);

        // プロジェクト3のタスク
        Task::create([
            'name' => 'ゲストタスク7',
            'project_id' => $project3->id,
            'start_date' => $currentDate->copy()->addDays(24)->format('Y-m-d'),
            'end_date' => $currentDate->copy()->addDays(27)->format('Y-m-d'),
            'completed' => 0,
        ]);

        Task::create([
            'name' => 'ゲストタスク8',
            'project_id' => $project3->id,
            'start_date' => $currentDate->copy()->addDays(28)->format('Y-m-d'),
            'end_date' => $currentDate->copy()->addDays(31)->format('Y-m-d'),
            'completed' => 0,
        ]);

        Task::create([
            'name' => 'ゲストタスク9',
            'project_id' => $project3->id,
            'start_date' => $currentDate->copy()->addDays(32)->format('Y-m-d'),
            'end_date' => $currentDate->copy()->addDays(35)->format('Y-m-d'),
            'completed' => 0,
        ]);

        // プロジェクト4のタスク
        Task::create([
            'name' => 'ゲストタスク10',
            'project_id' => $project4->id,
            'start_date' => $currentDate->copy()->addDays(36)->format('Y-m-d'),
            'end_date' => $currentDate->copy()->addDays(39)->format('Y-m-d'),
            'completed' => 0,
        ]);

        // プロジェクト5のタスク
        Task::create([
            'name' => 'ゲストタスク11',
            'project_id' => $project5->id,
            'start_date' => $currentDate->copy()->addDays(40)->format('Y-m-d'),
            'end_date' => $currentDate->copy()->addDays(43)->format('Y-m-d'),
            'completed' => 0,
        ]);
    }
}
