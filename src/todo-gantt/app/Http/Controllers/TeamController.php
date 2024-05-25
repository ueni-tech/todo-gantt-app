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
        $team = new Team();
        $team->name = $request->input('name');
        $team->save();

        $user = User::find(auth()->id());
        $user->selected_team_id = $team->id;
        $user->save();

        // ユーザーにチームを紐付ける
        $team->users()->attach(auth()->user());

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
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $team->name = $request->input('name');
        $team->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        $team->delete();

        return redirect()->route('index');
    }

    /**
     * チームを切り替える
     */
    public function change(Team $team)
    {
        $user = User::find(auth()->id());
        $user->selected_team_id = $team->id;
        $user->save();

        return redirect()->back();
    }
}
