<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('todos', compact('user'));
    }
}
