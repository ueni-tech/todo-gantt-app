<?php

namespace App\Models;

use App\Http\Requests\UploadImageRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Team extends Model
{
    use HasFactory;

    public function users()
    {
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

    public static function uploadImage(string $imageData, string $id)
    {
        $team = Team::find($id);
        if ($imageData) {
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
            $imageName = md5(uniqid(rand(), true)) . '.png';

            Storage::disk('public')->put('team_images/' . $imageName, $image);

            $team->image_name = $imageName;

            if ($team->isDirty('image_name') && $team->getOriginal('image_name') !== null) {
                static::deleteTeamIcon($id);
            }
            $team->save();
        }
    }

    public static function deleteTeamIcon(string $id)
    {
        $team = Team::find($id);
        Storage::disk('public')->delete('team_images/' . $team->image_name);
        $team->image_name = null;
        $team->save();
    }

    public static function checkAllTeamsHasUser()
    {
        $teams = Team::all();
        foreach ($teams as $team) {
            if ($team->users->count() === 0) {
                $team->delete();
            }
        }
    }
}
