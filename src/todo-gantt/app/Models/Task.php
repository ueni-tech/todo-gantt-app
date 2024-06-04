<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public static function createTask(Project $project, String $name, String $note, String $start_date, String $end_date): Task
    {
        $task = new Task();
        $task->project_id = $project->id;
        $task->name = $name;
        $task->note = $note;
        $task->start_date = $start_date;
        $task->end_date = $end_date;
        $task->save();
    
        return $task;
    }
}
