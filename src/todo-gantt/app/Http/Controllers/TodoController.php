<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        
        // selectedTeamとprojectsをeager loadingしてクエリを最適化
        $user = User::with(['teams', 'selectedTeam.projects' => function($query) use ($userId) {
            $query->where('user_id', $userId);
        }])->find($userId);
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        $teams = $user->teams;
        $current_team = $user->selectedTeam;
    
        if(!$current_team){
            return view('todos', [
                'user' => $user,
                'teams' => $teams,
                'current_team' => null,
                'projects' => []
            ]);
        }
        
        // 既にeager loadingされているので、直接アクセス可能
        $projects = $current_team->projects;
    
        return view('todos', compact('user', 'teams', 'current_team', 'projects'));
    }
}
