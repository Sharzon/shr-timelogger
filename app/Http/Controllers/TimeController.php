<?php

namespace App\Http\Controllers;

use App\Activity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\Request;

class TimeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $today = Carbon::today()->toDateTimeString();    
        $api_token = Auth::user()->api_token;
        // $activities = Activity::whereDate('start', $today)->get();
        // dd(count($activities));
        return view('time.activities', compact('api_token', 'today'));
    }
}
