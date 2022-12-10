<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\Task;

class TaskController extends Controller
{
    public function listTasks()
    {
        $tasks = Task::whereDate('task_date', Carbon::today())->orderBy('created_at', 'ASC')->get();

        return response($tasks);
    }

    public function createTask(Request $request)
    {
        $task = Task::create([
            'task' => $request->input('task'),
            'task_date' => Carbon::now()
        ]);

        return response([
            'error' => false,
            'message' => 'Task has been created successfully!'
        ], 200);
    }

    public function updateStatus(Request $request)
    {
        $task = Task::find($request->input('task'));
        $task->update([
            'status' => $request->input('status')
        ]);

        return response([
            'error' => false,
            'message' => 'Task status has been updated successfully'
        ]);
    }

    public function deleteTask($id)
    {
        $task = Task::destroy($id);

        return response([
            'error' => false,
            'message' => 'Task has been deleted successfully'
        ]);
    }
}
