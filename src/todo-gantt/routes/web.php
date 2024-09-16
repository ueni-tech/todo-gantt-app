<?php

use App\Http\Controllers\GanttchartController;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginAsGuestController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\UploadImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::resource('/', TodoController::class)->only('index')->middleware(['auth']);
Route::resource('todos', TodoController::class)->except(['index'])->middleware(['auth']);
Route::resource('ganttcharts', GanttchartController::class)->middleware(['auth']);
Route::resource('teams', TeamController::class)->middleware(['auth']);
Route::get('teams/{team}/change', [TeamController::class, 'change'])->name('teams.change');
Route::resource('projects', ProjectController::class)->middleware(['auth']);
Route::patch('projects/{project}/update-status', [ProjectController::class, 'updateStatus'])->middleware(['auth'])->name('projects.update-status');
Route::resource('tasks', TaskController::class)->middleware(['auth']);
Route::get('tasks/{task}/toggle', [TaskController::class, 'toggle'])->name('tasks.toggle');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__ . '/auth.php';

Route::middleware(['guest'])->group(function () {
    Route::get('/auth/google', [GoogleLoginController::class, 'redirectToGoogle'])
        ->name('login.google');

    Route::get('/auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])
        ->name('login.google.callback');

    Route::post('/login-as-guest', [LoginAsGuestController::class, 'loginAsGuest'])
        ->name('login-as-guest');
});

Route::get('/test', function () {
    session()->flash('flashError', 'エラーが発生しました');

    return view('test');
});

Route::resource('upload-image', UploadImageController::class)->only(['edit', 'update']);

Route::get('/get-sanctum-token', function (Request $request) {
    $token = $request->session()->get('sanctum_token');
    return response()->json(['token' => $token]);
})->middleware('auth');
