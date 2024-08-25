<?php

namespace App\Http\Controllers;

use App\Models\Gantt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GanttController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = Gantt::getGanttData($user);

        return response()->json($data);
    }
}
