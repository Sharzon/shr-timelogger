<?php

namespace App\Http\Controllers;

use App\Activity;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'date' => 'date'
        ]);

        $date = Carbon::parse($request->date)->toDateString();

        // dd($date);

        return response()->json(Activity::whereDate('start', $date)->get());
    }

    public function show(Request $request, $id) {
        
        return response()->json(Activity::findOrFail($id));
    }

    public function update(Request $request, $id) {
        $activity = Activity::findOrFail($id);

        // $this->validate($request, [
        // ]);
        
        $activity->name = $request->name;
        $activity->start = Carbon::parse($request->start);
        $activity->end = Carbon::parse($request->end);
        $activity->save();

        $activity = Activity::find($activity->id);

        return response()->json($activity);
    }
}
