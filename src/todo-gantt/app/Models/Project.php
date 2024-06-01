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

    public function scopeForUser($query, $user): Builder
    {
        return $query->where('user_id', $user->id);
    }

    public static function createProject($user, $current_team, $name)
    {
        $project = new Project();
        $project->name = $name;
        $project->team_id = $current_team->id;
        $project->user_id = $user->id;
        $project->save();
        
        return $project;
    }
}
