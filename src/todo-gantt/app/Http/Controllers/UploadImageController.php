<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadImageRequest;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadImageController extends Controller
{
  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $teams = User::find(auth()->id())->teams;
    $team = User::find(auth()->id())->selectedTeam;

    return view('uploadImage', compact('teams', 'team'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(UploadImageRequest $request, string $id)
  {
    $imageData = $request->input('image_data');
    Team::uploadImage($imageData, $id);

    return redirect()->back();
  }
}
