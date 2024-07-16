<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'team_id',
        'user_id',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class);
    }

    public function scopeForUser($query, $user): Builder
    {
        return $query->where('user_id', $user->id);
    }

    public static function createProject(User $user, Team $current_team, string $name): Project
    {
        $defaultStatus = ProjectStatus::where('name', 'incomplete')->first();
        $project = new Project();
        $project->name = $name;
        $project->team_id = $current_team->id;
        $project->user_id = $user->id;
        $project->status_id = $defaultStatus->id;
        $project->save();
        
        return $project;
    }

    public static function updateName(String $name, Project $project): Project
    {
        $project->name = $name;
        $project->save();

        return $project;
    }
}
