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

        $projects = $current_team->projects()
            ->where('status_name', 'incomplete')
            ->with(['tasks' => function ($query) {
                $query->orderBy('start_date', 'asc');
            }, 'user'])
            ->get();

        $processedProjects = $projects->map(function ($project) {
            return static::processProject($project);
        });

        $sortedProjects = $processedProjects->sortBy(function ($project) {
            return $project['start'] ?? PHP_INT_MAX;
        });

        $sortedProjects = $sortedProjects->sort(function ($a, $b) use ($user) {
            if ($a['user_id'] == $user->id && $b['user_id'] != $user->id) {
                return -1;
            }
            if ($a['user_id'] != $user->id && $b['user_id'] == $user->id) {
                return 1;
            }
            return $a['user_id'] <=> $b['user_id'];
        });

        return $sortedProjects->values()->toArray();
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
        return $tasks->map(function($task) use ($project) {
            return [
                'id' => (string) $task->id,
                'name' => $task->name,
                'start' => $task->start_date,
                'end' => $task->end_date,
                'progress' => 0,
                'custom_class' => "user-{$task->user_id}-task",
                'user' => $project->name,
                'user_id' => $project->user_id,
                'completed' => $task->completed
            ];
        });
    }
}
