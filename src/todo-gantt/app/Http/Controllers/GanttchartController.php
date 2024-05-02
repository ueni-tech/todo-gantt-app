<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GanttchartController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('ganttchart', compact('user'));
    }
}
