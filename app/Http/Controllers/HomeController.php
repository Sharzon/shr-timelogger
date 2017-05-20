<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\TimeController;

class HomeController extends Controller
{
    public function index(TimeController $timeController)
    {
        if (Auth::check()) {
            return $timeController->dashboard();
        } else {
            return view('main');
        }
    }
}
