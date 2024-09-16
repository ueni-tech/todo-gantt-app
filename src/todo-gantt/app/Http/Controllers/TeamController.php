<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Models\Team;
use App\Models\User;

class TeamController extends Controller
{
    public function store(TeamRequest $request)
    {
        $team = Team::createTeam($request->input('team_name'));
        // ユーザーにチームを紐付ける
        $team->users()->attach(auth()->user());

        $user = User::find(auth()->id());
        User::changeCurrentTeam($user, $team);

        session()->flash('flashSuccess', 'チームを作成しました');
        return redirect()->back();
    }

    public function update(TeamRequest $request, Team $team)
    {
        $team = Team::updateName($request->input('team_name'), $team);

        session()->flash('flashInfo', 'チーム情報を更新しました');
        return redirect()->back();
    }

    public function destroy(Team $team)
    {
        if ($team->image_name) {
            Team::deleteTeamIcon($team->id);
        }
        $team->delete();

        $user = User::find(auth()->id());
        if ($user->teams->count() > 0) {
            User::changeCurrentTeam($user, $user->teams->first());
        }

        session()->flash('flashInfo', 'チームを削除しました');
        return redirect()->route('index');
    }

    public function change(Team $team)
    {
        $user = User::find(auth()->id());
        User::changeCurrentTeam($user, $team);

        return redirect()->back();
    }
}
