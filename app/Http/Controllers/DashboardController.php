<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Task_User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        list($first_name, $last_name) = explode(' ', Auth::user()->name, 2);
        $tasks_user = Task_User::with([
            'task' => function ($query) {
                $query->orderBy('deadline', 'asc');
            },
            'task.orderer',
            'user'
        ])->where('user_id', Auth::user()->id)->where('confirmed', 0)->take(5)->get();
        $notifications = Auth::user()->notifications()->latestTen()->get();
        return view('dashboard.main', compact('first_name', 'last_name', 'tasks_user', 'notifications'));
    }
}
