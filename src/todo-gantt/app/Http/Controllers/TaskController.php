<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
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
    public function store(TaskRequest $request)
    {
        $project = Project::find($request->project_id);        
        Task::createTask($project, $request->task_name, $request->note, $request->start_date, $request->end_date);

        session()->flash('flashSuccess', 'タスクを作成しました');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, Task $task)
    {
        Task::updateTask($task, $request->task_name, $request->note, $request->start_date, $request->end_date);

        session()->flash('flashInfo', 'タスク情報を更新しました');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        session()->flash('flashInfo', 'タスクを削除しました');
        return redirect()->back();
    }

    public function toggle(Task $task)
    {
        Task::toggleCompleted($task);

        return redirect()->back();
    }
}
