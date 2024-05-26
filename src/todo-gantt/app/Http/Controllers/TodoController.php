<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $teams = $user->teams;
        $current_team = Team::find($user->selected_team_id);
        if(!$current_team){
            $current_team = [];
            $projects = [];
        } else {
            $projects = $current_team->projects()->where('user_id', $user->id)->get();
        }
        return view('todos', compact('user', 'teams', 'current_team', 'projects'));
    }
}
