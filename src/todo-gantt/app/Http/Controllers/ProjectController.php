<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
  public function store(ProjectRequest $request)
  {
    $user = auth()->user();
    $current_team = $user->selectedTeam;

    Project::createProject($user, $current_team, $request->project_name);

    session()->flash('flashSuccess', 'プロジェクトを作成しました');
    return redirect()->back();
  }

  public function update(ProjectRequest $request, Project $project)
  {
    Project::updateName($request->project_name, $project);

    session()->flash('flashInfo', 'プロジェクト情報を更新しました');
    return redirect()->back();
  }

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


    $project->status_name = $request->status;
    $project->save();

    session()->flash('flashInfo', 'プロジェクトステータスを更新しました');
    return redirect()->back();
  }
}
