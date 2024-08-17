<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class Gantt extends Model
{
    use HasFactory;

    public static function getGanttData(User $user): array
    {
        $current_team = $user->selectedTeam;
        $projects = $current_team->projects()->with(['tasks' => function($query) {
            $query->orderBy('start_date');
        }, 'user'])->get();

        $ganttData = [];

        foreach ($projects as $project) {
            $projectData = static::processProject($project);
            $ganttData[] = $projectData;
        }

        return $ganttData;
    }

    private static function processProject($project): array
    {
        $tasks = $project->tasks;

        $projectData = [
            'id' => "project-{$project->id}",
            'name' => $project->name,
            'start' => '',
            'end' => '',
            'progress' => 0,
            'dependencies' => null,
            'user_id' => $project->user_id,
            'user_name' => $project->user->name,
        ];

        $processedTasks = static::processTasks($tasks, $project);

        if ($processedTasks->isNotEmpty()) {
            $projectData['start'] = $processedTasks->min('start');
            $projectData['end'] = $processedTasks->max('end');
        }

        return array_merge($projectData, ['tasks' => $processedTasks->toArray()]);
    }

    private static function processTasks(Collection $tasks, Project $project): Collection
    {
        $processedTasks = collect();

        foreach ($tasks as $task) {
            $taskData = [
                'id' => (string) $task->id,
                'name' => $task->name,
                'start' => $task->start_date,
                'end' => $task->end_date,
                'progress' => 0,
                'custom_class' => "user-{$task->user_id}-task",
                'user' => $project->name,
                'user_id' => $project->user_id,
            ];

            $processedTasks->push($taskData);
        }

        return $processedTasks;
    }
}
