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
        $current_team = $user->selectedTeam;

        if(!$current_team){
            return view('todos', [
                'user' => $user,
                'teams' => $teams,
                'current_team' => null,
                'projects' => []
            ]);
        }
        $projects = $current_team->projects()->forUser($user)->get();

        return view('todos', compact('user', 'teams', 'current_team', 'projects'));
    }
}
