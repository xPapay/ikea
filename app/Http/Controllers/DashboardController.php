<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        list($first_name, $last_name) = explode(' ', Auth::user()->name, 2);
        $tasks = Auth::user()->tasks()->unfinished(5)->get();
        return view('dashboard.main', compact('first_name', 'last_name', 'tasks'));
    }
}
