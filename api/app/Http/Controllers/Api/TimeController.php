<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;
use Carbon\CarbonInterval;

use App\Models\Time;

class TimeController extends Controller
{
    public function listTimes(Request $request)
    {
        $minutes = 0;

        $date = $request->has('date') ? Carbon::parse($request->input('date')) : Carbon::today();
        
        $times = Time::whereDate('date', $date)
                        ->orderBy('created_at', 'ASC')
                        ->get()->map(function($time) {
                            $minutes = Carbon::parse($time->end)->diffInMinutes(Carbon::parse($time->start));
                            $total_time = CarbonInterval::minutes($minutes)->cascade()->forHumans();

                            return collect([
                                'id' => $time->id,
                                'date' => $time->date,
                                'start' => $time->start,
                                'end' => $time->end,
                                'description' => $time->description,
                                'created_at' => $time->created_at,
                                'updated_at' => $time->updated_at,
                                // 'is_today' => Carbon::parse($time->created_at)->isToday(),
                                'is_today' => $time->is_today,
                                'minutes' => $minutes,
                                'total_time' => $total_time
                            ]);
                        });

        $total_minutes = $times->sum('minutes');
        $time_spent = CarbonInterval::minutes($total_minutes)->cascade()->forHumans();

        return response([
            'times' => $times,
            'total' => [
                'minutes' => $total_minutes,
                'time' => $time_spent
            ]
        ]);
    }

    public function addTime(Request $request)
    {
        $date = $request->has('date') ? Carbon::parse($request->input('date')) : Carbon::today();
        $time = Time::create([
            'date' => $date,
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

    public function moveTime($id)
    {
        $time = Time::find($id);
        if($time) {
            $time->update([
                'date' => Carbon::today()
            ]);
        }

        return response([
            'error' => false,
            'message' => 'Task has been moved successfully'
        ]);
    }
}
