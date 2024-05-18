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
        return view('todos', compact('user', 'teams', 'current_team'));
    }
}
