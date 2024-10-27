<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $user = User::with('teams')->find(auth()->id());
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
    
        $current_team->load(['projects' => function($query) use ($user) {
            $query->forUser($user);
        }]);
        
        $projects = $current_team->projects;
    
        return view('todos', compact('user', 'teams', 'current_team', 'projects'));
    }
}
