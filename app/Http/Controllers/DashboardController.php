<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Task_User;
use App\User_Support_Task;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        list($first_name, $last_name) = explode(' ', Auth::user()->name, 2);
        $tasks_user = Task_User::with([
            'task' => function ($query) {
                $query->orderBy('deadline', 'asc');
            },
            'task.orderer',
            'user'
        ])->join('tasks', 'tasks.id', '=', 'task_user.task_id')
        ->where('user_id', Auth::user()->id)->where('confirmed', 0)->orderBy('tasks.deadline')->take(5)->get();

        $supported_tasks = User_Support_Task::with([
            'task'
        ])
        ->join('tasks', 'tasks.id', '=', 'user_support_task.task_id')
        ->where('user_support_task.user_id', '=', Auth::user()->id)
        ->orderBy('tasks.deadline')->take(5)->get();
        //dd($supported_tasks);
        $notifications = Auth::user()->notifications()->latestTen()->get();
        return view('dashboard.main', compact('user', 'first_name', 'last_name', 'tasks_user', 'supported_tasks', 'notifications'));
    }
}
