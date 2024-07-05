<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
    if ($request->hasFile('image_name')) {
      // アップロードされたファイル（name="image"）をstorage/app/public/productsフォルダに保存し、戻り値（ファイルパス）を変数$image_pathに代入する
      $image_path = $request->file('image_name')->store('public/team_images');
    } else {
      return redirect()->route('index');
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
