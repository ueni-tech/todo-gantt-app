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

    public static function updateImage(UploadImageRequest $request, string $id)
    {
        $imageData = $request->input('image_data');
        $team = Team::find($id);
        if ($imageData) {
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
            $imageName = md5(uniqid(rand(), true)) . '.png';

            Storage::disk('public')->put('team_images/' . $imageName, $image);

            $team->image_name = $imageName;
            if ($team->getOriginal('image_name')) {
                Storage::disk('public')->delete('team_images/' . $team->getOriginal('image_name'));
            }
            $team->save();
        }
    }
}
