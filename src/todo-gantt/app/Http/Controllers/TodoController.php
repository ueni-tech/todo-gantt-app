<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index($team)
    {
        $user = auth()->user();
        $teams = $user->teams;
        $nowTeam = $teams->where('id', $team)->first();
        return view('todos', compact('user', 'teams', 'nowTeam'));
    }
}
