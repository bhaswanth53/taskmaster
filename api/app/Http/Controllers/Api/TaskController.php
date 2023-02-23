<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\Task;

class TaskController extends Controller
{
    public function listTasks(Request $request)
    {
        // $start_date = $request->has('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::today();
        // $end_date = $request->has('end_date') ? Carbon::parse($request->input('end_date')) : NULL;
        // $today = ($request->has('today') && (boolean) $request->input('today') != false) ? Carbon::today() : NULL;
        
        // $tasks = Task::when($today != NULL, function($q) {
        //                     $q->whereDate('task_date', Carbon::today());
        //                 })
        //                 ->when($today == NULL && $start_date != NULL, function($q) use($start_date) {
        //                     $q->whereDate('task_date', '>=', $start_date);
        //                 })
        //                 ->when($today == NULL && $end_date != NULL, function($q) use($end_date) {
        //                     $q->whereDate('task_date', '<=', $end_date);
        //                 })
        //                 ->orderBy('created_at', 'ASC')
        //                 ->get();

        $date = $request->has('date') ? Carbon::parse($request->input('date')) : Carbon::today();
        $tasks = Task::whereDate('task_date', $date)->orderBy('created_at', 'ASC')->get();

        return response([
            'data' => $tasks
        ]);
    }

    public function createTask(Request $request)
    {
        $date = Carbon::parse($request->input('task_date'));
        $task = Task::create([
            'task' => $request->input('task'),
            'task_date' => $date
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

    public function moveTask($id)
    {
        $task = Task::find($id);
        if($task) {
            $task->update([
                'task_date' => Carbon::today()
            ]);
        }

        return response([
            'error' => false,
            'message' => 'Task has been moved successfully'
        ]);
    }
}
