<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class GanttchartController extends Controller
{
    public function index()
    {
        $user = User::with('teams')->find(auth()->id());
        $teams = $user->teams;
        return view('ganttchart', compact('user', 'teams'));
    }
}
