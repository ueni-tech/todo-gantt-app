<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

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
}
