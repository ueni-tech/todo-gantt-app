<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function getNameAttribute($value)
    {
        return trim($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = trim($value);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public static function createTeam(String $name): Team
    {
        $team = new Team();
        $team->name = $name;
        $team->save();
        
        return $team;
    }

    public static function updateName(String $name, Team $team): Team
    {
        $team->name = $name;
        $team->save();
        
        return $team;
    }
}
