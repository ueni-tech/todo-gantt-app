<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TeamRequest $request)
    {
        $team = Team::createTeam($request->input('name'));
        // ユーザーにチームを紐付ける
        $team->users()->attach(auth()->user());

        $user = User::find(auth()->id());
        User::changeCurrentTeam($user, $team);

        session()->flash('flashSuccess', 'チームを作成しました');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TeamRequest $request, Team $team)
    {
        $team = Team::updateName($request->input('name'), $team);

        session()->flash('flashInfo', 'チーム情報を更新しました');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();

        session()->flash('flashInfo', 'チームを削除しました');
        return redirect()->route('index');
    }

    /**
     * チームを切り替える
     */
    public function change(Team $team)
    {
        $user = User::find(auth()->id());
        User::changeCurrentTeam($user, $team);

        return redirect()->back();
    }
}
