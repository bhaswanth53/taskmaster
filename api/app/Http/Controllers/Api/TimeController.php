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
        $start_date = $request->has('start_date') ? Carbon::parse($request->input('start_date')) : Carbon::today();
        $end_date = $request->has('end_date') ? Carbon::parse($request->input('end_date')) : NULL;
        $today = ($request->has('today') && (boolean) $request->input('today') != false) ? Carbon::today() : NULL;
        
        $times = Time::when($today != NULL, function($q) {
                            $q->whereDate('date', Carbon::today());
                        })
                        ->when($today == NULL && $start_date != NULL, function($q) use($start_date) {
                            $q->whereDate('date', '>=', $start_date);
                        })
                        ->when($today == NULL && $end_date != NULL, function($q) use($end_date) {
                            $q->whereDate('date', '<=', $end_date);
                        })
                        ->orderBy('created_at', 'ASC')
                        ->get();

        return response($times);
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
}
