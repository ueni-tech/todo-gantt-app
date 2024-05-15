<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $teams = $user->teams;
        return view('todos', compact('user', 'teams'));
    }
}
