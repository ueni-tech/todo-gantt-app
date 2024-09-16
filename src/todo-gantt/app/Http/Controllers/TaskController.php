<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\Project;
use App\Models\Task;

class TaskController extends Controller
{
    public function store(TaskRequest $request)
    {
        $project = Project::find($request->project_id);        
        Task::createTask($project, $request->task_name, $request->note, $request->start_date, $request->end_date);

        session()->flash('flashSuccess', 'タスクを作成しました');
        return redirect()->back();
    }

    public function update(TaskRequest $request, Task $task)
    {
        Task::updateTask($task, $request->task_name, $request->note, $request->start_date, $request->end_date);

        session()->flash('flashInfo', 'タスク情報を更新しました');
        return redirect()->back();
    }

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
