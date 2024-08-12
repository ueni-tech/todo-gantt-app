<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Gantt extends Model
{
    use HasFactory;

    public static function getGanttData($user)
    {
        $current_team = $user->selectedTeam;
        $projects = $current_team->projects;

        $ganttData = [];

        foreach ($projects as $project) {
            $tasks = $project->tasks;
            $projectData = [
                'id' => $project->id,
                'name' => $project->name,
                'tasks' => [],
                'user_id' => $project->user_id,
                'user_name' => $project->user->name,
            ];

            foreach ($tasks as $task) {
                $taskData = [
                    'id' => $task->id,
                    'name' => $task->name,
                    'start_date' => $task->start_date,
                    'end_date' => $task->end_date,
                ];

                $projectData['tasks'][] = $taskData;
            }

            $ganttData[] = $projectData;
        }

        return $ganttData;
    }
}
