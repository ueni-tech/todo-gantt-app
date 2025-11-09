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
        // ユーザーとselectedTeamをeager loadingしてクエリを最適化
        $user = User::with('selectedTeam')->find(Auth::id());
        
        if (!$user) {
            return response()->json([], 401);
        }
        
        $data = Gantt::getGanttData($user);

        return response()->json($data);
    }
}
