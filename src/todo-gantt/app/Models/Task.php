<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['start_date', 'end_date', 'project_id', 'name', 'note', 'completed'];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($task) {
            $task->validate();
        });
    }

    public function validate()
    {
        $validator = Validator::make($this->attributes, [
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public static function createTask(Project $project, String $name, ?String $note, String $start_date, String $end_date): Task
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

    public static function updateTask(Task $task, String $name, ?String $note, String $start_date, String $end_date): Task
    {
        $task->name = $name;
        $task->note = $note;
        $task->start_date = $start_date;
        $task->end_date = $end_date;
        $task->save();

        return $task;
    }

    public static function toggleCompleted(Task $task): Task
    {
        $task->completed = !$task->completed;
        $task->save();

        return $task;
    }
}
