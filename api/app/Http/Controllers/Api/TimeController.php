<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Models\Time;

class TimeController extends Controller
{
    public function listTimes(Request $request)
    {
        $times = Time::whereDate('date', Carbon::today())->orderBy('created_at', 'ASC')->get();

        return response($times);
    }

    public function addTime(Request $request)
    {
        $time = Time::create([
            'date' => Carbon::today(),
            'start' => $request->input('start'),
            'end' => $request->input('end'),
            "description" => $request->input("description")
        ]);

        return response([
            'error' => false,
            'message' => 'Timelog has been added successfully'
        ]);
    }

    public function updateTime(Request $request)
    {
        $time = Time::find($request->input('time'));
        $time->update([
            'date' => Carbon::today(),
            'start' => $request->input('start'),
            'end' => $request->input('end'),
            "description" => $request->input("description")
        ]);

        return response([
            'error' => false,
            'message' => 'Timelog has been updated successfully'
        ]);
    }

    public function deleteTime($id)
    {
        $time = Time::destroy($id);

        return response([
            'error' => false,
            'message' => 'Timelog has been deleted successfully'
        ]);
    }
}
