<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\ShowTaskRequest;
use App\Http\TaskStatus;
use App\Tag;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class TasksController extends Controller
{

    /**
     * Display a listing of user's tasks.
     *
     * @param string $status
     * @return \Illuminate\Http\Response
     */
    public function index($status = 'unfinished')
    {
        $status = new TaskStatus($status);

        $tasks = Auth::user()->tasks()->withStatus($status->getSelectedKey())->get();

        $selectedStatus = $status->getSelectedValue();
        $statusMenu = $status->getStatusMenu('tasks/filter/');

        return view('tasks.index', compact('tasks', 'selectedStatus', 'statusMenu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::lists('name', 'id');
        $tags = Tag::lists('name', 'id');
        return view('tasks.create', compact('users', 'tags'));
    }

    /**
     * Store a newly created task in storage.
     *
     * @param \App\Http\Requests\AddTaskRequest
     * @return \Illuminate\Http\Response
     */
    public function store(AddTaskRequest $request)
    {
        Auth::user()->orderTask(new Task($request->all()), $request->executorsList, $request->tagsList);

        // TODO: flashing messages
        return redirect('/tasks/ordered');
    }


    /**
     * Show task's details
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $task = Task::where('id', $request->tasks->id)->firstOrFail();

        if (Gate::denies('show', $task))
        {
            return $this->unauthorizedResponse($request);
        }

        if ($request->ajax())
        {
            return $task;
        }

        return view('tasks.show', compact('task'));
    }

    public function showAll(Request $request, $status = 'all')
    {
        if (!Auth::user()->isAdmin())
        {
            return $this->unauthorizedResponse($request);
        }
        $status = new TaskStatus($status);

        $tasks = Task::withStatus($status->getSelectedKey())->get();

        $selectedStatus = $status->getSelectedValue();
        $statusMenu = $status->getStatusMenu('admin/tasks/');

        return view('tasks.show_all', compact('tasks', 'selectedStatus', 'statusMenu'));
    }

    public function showOrdered($status = 'unfinished')
    {
        $status = new TaskStatus($status);

        $tasks = Auth::user()->orderedTasks()->withStatus($status->getSelectedKey())->with('executors')->get();

        $selectedStatus = $status->getSelectedValue();
        $statusMenu = $status->getStatusMenu('tasks/ordered/filter/');
        return view('tasks.ordered', compact('tasks', 'selectedStatus', 'statusMenu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $task = Task::findOrFail($request->tasks->id);

        if (Gate::denies('edit', $task))
        {
            return $this->unauthorizedResponse($request);
        }

        $users = User::lists('name', 'id');
        return view('tasks.edit', compact('task', 'users'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);
        $task->update($request->all());
        $task->assignToUsers($request->input('executorsList'));

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function accomplish(Task $task, Request $request)
    {
        if (Gate::denies('accomplish', $task))
        {
            return $this->unauthorizedResponse($request);
        }
        $task->accomplish_date = Carbon::now();
        $task->save();
        return redirect('/');
    }

    public function accept(Task $task, Request $request)
    {
        if (Gate::denies('determine', $task))
        {
            return $this->unauthorizedResponse($request);
        }
        $task->confirmed = 1;
        $task->save();
        return redirect('tasks/ordered/filter/to_confirmation');
    }

    public function reject(Task $task, Request $request)
    {
        if (Gate::denies('determine', $task))
        {
            return $this->unauthorizedResponse($request);
        }
        $task->confirmed = 0;
        $task->accomplish_date = null;
        $task->save();
        return redirect('tasks/ordered/filter/to_confirmation');
    }

    private function getId($string)
    {
        preg_match('/task_id-(\d+)$/', $string, $match);
        return $match[1];
    }

    /**
     * Returns appropriate response if user is not authorized
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    private function unauthorizedResponse(Request $request)
    {
        if ($request->ajax())
        {
            return new Response('Nemáte oprávnenia prezerať túto úlohu', 403);
        }

        return new Response(view('errors.403'), 403);
    }

}
