<?php

namespace Database\Seeders;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UpdatedGuestTaskSeeder extends Seeder
{
    public function run()
    {
        // user_id が 1 のプロジェクトを削除
        Project::where('user_id', 1)->delete();

        // user_id が 1 のプロジェクトを2つ作成(factoryを使用ぜずに)
        $projects = [
            Project::create([
                'user_id' => 1,
                'name' => 'ゲストプロジェクト1',
                'team_id' => 1,
                'status_name' => 'incomplete',
            ]),
            Project::create([
                'user_id' => 1,
                'name' => 'ゲストプロジェクト2',
                'team_id' => 1,
                'status_name' => 'incomplete',
            ]),
        ];


        // 現在の日付を取得
        $currentDate = Carbon::now();

        foreach ($projects as $key => $project) {
            // 各プロジェクトに3つのタスクを作成
            for ($i = 1; $i <= 3; $i++) {
                $startDate = $currentDate->copy()->addDays(($i * 4) + ($key * 12));
                $endDate = $startDate->copy()->addDays(3);

                Task::create([
                    'name' => "ゲストタスク{$i}",
                    'project_id' => $project->id,
                    'start_date' => $startDate->format('Y-m-d'),
                    'end_date' => $endDate->format('Y-m-d'),
                    'completed' => 0,
                ]);
            }
        }

        // userのnameがAさんのユーザーに紐づくプロジェクトを削除
        $guestMember = User::where('name', 'Aさん')->first();
        $guestMember->projects()->delete();

        // userのnameがAさんのユーザーに紐づくプロジェクトを作成
        $project = Project::create([
            'user_id' => $guestMember->id,
            'name' => 'Aさんのプロジェクト',
            'team_id' => 1,
            'status_name' => 'incomplete',
        ]);

        // 各プロジェクトに3つのタスクを作成
        for ($i = 1; $i <= 3; $i++) {
            $startDate = $currentDate->copy()->addDays(($i) * 4);
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
