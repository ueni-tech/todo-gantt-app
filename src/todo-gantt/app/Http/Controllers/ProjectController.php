<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Livewire\Attributes\Validate;

class ProjectController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    //
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
  public function store(ProjectRequest $request)
  {
    $user = auth()->user();
    $current_team = $user->selectedTeam;

    Project::createProject($user, $current_team, $request->project_name);

    session()->flash('flashSuccess', 'プロジェクトを作成しました');
    return redirect()->back();
  }

  /**
   * Display the specified resource.
   */
  public function show(Project $project)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Project $project)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(ProjectRequest $request, Project $project)
  {
    Project::updateName($request->project_name, $project);

    session()->flash('flashInfo', 'プロジェクト情報を更新しました');
    return redirect()->back();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Project $project)
  {
    $project->delete();

    session()->flash('flashInfo', 'プロジェクトを削除しました');
    return redirect()->back();
  }

  public function updateStatus(Project $project, Request $request)
  {
    $request->validate([
      'status' => 'required|string|exists:project_statuses,name'
    ]);

    $status_id = ProjectStatus::where('name', $request->status)->first()->id;

    $project->status_id = $status_id;
    $project->save();

    session()->flash('flashInfo', 'プロジェクトステータスを更新しました');
    return redirect()->back();
  }
}
