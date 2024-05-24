<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GanttchartController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $teams = $user->teams;
        return view('ganttchart', compact('user', 'teams'));
    }
}
