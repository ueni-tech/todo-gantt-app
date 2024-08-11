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
        $data = Gantt::getGanttData();

        return response()->json($data);
    }
}
