<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadImageController extends Controller
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
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    //
  }

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
  public function update(Request $request, string $id)
  {
    $imageData = $request->input('image_data');
    $team = Team::find($id);

    if ($imageData) {
        $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));
        // ユニークな$imageNameを生成
        $imageName = md5(uniqid(rand(), true)) . '.png';

        // 画像をストレージに保存する
        Storage::disk('public')->put('team_images/' . $imageName, $image);

        // $teamのimage_nameを文字列にして更新する
        $team->image_name = $imageName;
        // 更新前の画像を削除する
        if ($team->getOriginal('image_name')) {
            Storage::disk('public')->delete('team_images/' . $team->getOriginal('image_name'));
        }
        $team->save();

    }

    return redirect()->back();
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    //
  }
}
