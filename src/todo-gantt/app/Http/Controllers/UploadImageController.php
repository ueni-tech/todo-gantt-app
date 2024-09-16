<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadImageRequest;
use App\Models\Team;
use App\Models\User;

class UploadImageController extends Controller
{
  public function edit(string $id)
  {
    $user = User::with(['teams', 'selectedTeam'])->find(auth()->id());
    $teams = $user->teams;
    $team = $user->selectedTeam;

    return view('uploadImage', compact('teams', 'team'));
  }

  public function update(UploadImageRequest $request, string $id)
  {
    $imageData = $request->input('image_data');
    Team::uploadImage($imageData, $id);

    return redirect()->back();
  }
}
