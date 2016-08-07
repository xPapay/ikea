<?php

namespace App\Http\Controllers;

use App\Http\FileUpload;
use App\Http\Requests\AddTaskRequest;
use App\Http\TaskFilter;
use App\Notification;
use App\Tag;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use App\Events\TaskWasCreated;
use App\Events\TaskWasEdited;
use App\Events\ExecutorWasAddedToTask;
use App\Events\ExecutorWasRemovedFromTask;
use App\Events\TaskWasDeleted;
use App\Events\TaskWasAccepted;
use App\Events\TaskWasAccomplished;
use App\Events\TaskWasRejected;

use DB;

class TasksController extends Controller
{

    /**
     * Display a listing of user's tasks.
     *
     * @param string $status
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $initial_query = Auth::user()->tasks();
        $filter = new TaskFilter($request, $initial_query);
        $tasks_query = $filter->addFilterQuery();
        $tasks_query = $tasks_query->orderBy('deadline', 'asc');
        $tasks = $tasks_query->paginate(20)->appends(Input::except('page'));

        $selectableOptions = $filter->getSelectableOptions();
        $filters = $filter->getFilters();

        return view('tasks.index', compact('tasks', 'selectableOptions', 'filters'));
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddTaskRequest $request)
    {
        $task = Auth::user()->orderTask(new Task($request->all()), $request->executorsList, $request->tagsList);
        $fileUploader = new FileUpload($request->file('files'), $task);
        $fileUploader->handleFilesUpload();

        $usersToNotify = $request->executorsList;
        $notification = $this->createNotification('Úloha vytvorená', Auth::user()->id, $task, $usersToNotify);
        session()->flash('flash_success', 'Úloha bola úspešne vytvorená');
        

        return redirect('/tasks/ordered');
    }

    public function createNotification($type, $initiator, $task, $usersToNotify)
    {
        $notification = Notification::create(['type' => $type, 'user_id' => $initiator, 'task_id' => $task->id]);
        $notification->involved_users()->sync($usersToNotify);

        event(new TaskWasCreated($notification));

        return $notification;
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

        if (Gate::denies('show', $task)) {
            return $this->unauthorizedResponse($request);
        }

        if ($request->ajax()) {
            return $task;
        }

        return view('tasks.show', compact('task'));
    }

    public function filter(Request $request)
    {
        $initial_query = Task::select();
        $filter = new TaskFilter($request, $initial_query);
        $tasks_query = $filter->addFilterQuery();

        $tasks = $tasks_query->paginate(20)->appends(Input::except('page'));
        $selectableOptions = $filter->getSelectableOptions();
        $filters = $filter->getFilters();
        return view('tasks.show_all', compact('tasks', 'selectableOptions', 'filters'));
    }

    public function showOrdered(Request $request)
    {
        $initial_query = Auth::user()->orderedTasks()->with('executors');

        $filter = new TaskFilter($request, $initial_query);
        $tasks_query = $filter->addFilterQuery();

        $tasks = $tasks_query->orderBy('deadline')->paginate(20)->appends(Input::except('page'));

        $selectableOptions = $filter->getSelectableOptions();
        $filters = $filter->getFilters();

        return view('tasks.ordered', compact('tasks', 'selectableOptions', 'filters'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $task = Task::findOrFail($request->tasks->id);

        if (Gate::denies('edit', $task)) {
            return $this->unauthorizedResponse($request);
        }

        $users = User::lists('name', 'id');
        $tags = Tag::lists('name', 'id');
        return view('tasks.edit', compact('task', 'users', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Task $task
     * @return \Illuminate\Http\Response
     */
    public function update(AddTaskRequest $request, Task $task)
    {   
        $originExecutors = $task->executors;

        $task->update($request->all());
        $task->assignToUsers($request->input('executorsList'));
        $task->assignTag($request->input('tagsList', array()));

        $user_id = Auth::user()->id;
        $executorsAndOrderer = $request->executorsList;
        array_push($executorsAndOrderer, $user_id);
        $notification = Notification::create(['type' => 'Úloha editovaná', 'user_id' => $user_id, 'task_id' => $task->id]);
        $notification->involved_users()->sync($executorsAndOrderer);
        $removedUsers = $this->notifyRemovedUsers($notification, $request->executorsList, $originExecutors);
        $addedUsers = $this->notifyAddedUsers($notification, $request->executorsList, $originExecutors);

        $removedAndAddedUsers = $removedUsers->merge($addedUsers);

        $this->notifyAboutTaskChange($notification, $removedAndAddedUsers);

        

        session()->flash('flash_success', 'Úloha bola úspešne editovaná');

        return redirect('tasks/' . $task->id);
    }

    public function notifyAboutTaskChange($notification, $removedAndAddedUsers)
    {
        //TODO: hash origin task and request fields and compare them. If not match task was edited.
        event(new TaskWasEdited($notification, $notification->task->executors->diff($removedAndAddedUsers)));
    }

    public function notifyAddedUsers($notification, $newExecutorsId, $originExecutors)
    {
        $newExecutors = User::find($newExecutorsId);
        $addedUsers = $newExecutors->diff($originExecutors);

        if ($addedUsers->count() == 0) {
            return collect();
        }
        event(new ExecutorWasAddedToTask($notification, $addedUsers));
        return $addedUsers;
    }

    public function notifyRemovedUsers($notification, $newExecutorsId, $originExecutors)
    {
        $newExecutors = User::find($newExecutorsId);
        $removedUsers = $originExecutors->except($newExecutorsId);
        if ($removedUsers->count() == 0) {
            return collect();
        }
        event(new ExecutorWasRemovedFromTask($notification, $removedUsers));
        return $removedUsers;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $task)
    {
        if (Gate::denies('edit', $task)) {
            return $this->unauthorizedResponse($request);
        }
        $notification = Notification::create(['type' => 'Úloha zmazaná', 'user_id' => Auth::user()->id, 'task_id' => $task->id]);
        $taskName = $task->name;
        $taskExecutors = $task->executors;
        $task->delete();
        event(new TaskWasDeleted($taskName, $taskExecutors));
        session()->flash('flash_success', 'Úloha bola úspešne zmazaná');
        return redirect('tasks/ordered');
    }

    public function accomplish(Task $task, Request $request)
    {
        if (Gate::denies('accomplish', $task)) {
            return $this->unauthorizedResponse($request);
        }
        $task->accomplish_date = Carbon::now();
        $task->save();

        $user_id = Auth::user()->id;
        $notification = Notification::create(['type' => 'Úloha dokončená', 'user_id' => $user_id, 'task_id' => $task->id]);
        $executorsAndOrderer = $task->executors->lists('id')->toArray();
        array_push($executorsAndOrderer, $task->orderer->id);
        $notification->involved_users()->sync($executorsAndOrderer);
        event(new TaskWasAccomplished($notification));
        session()->flash('flash_info', 'Úloha čaká na schválenie zadávateľom');
        return redirect()->back();
    }

    public function accept(Task $task, Request $request)
    {
        if (Gate::denies('determine', $task)) {
            return $this->unauthorizedResponse($request);
        }
        $task->confirmed = 1;
        $task->save();
        $notification = Notification::create(['type' => 'Úloha akceptovaná', 'user_id' => Auth::user()->id, 'task_id' => $task->id]);
        $executorsAndOrderer = $task->executors->lists('id')->toArray();
        array_push($executorsAndOrderer, $task->orderer->id);
        $notification->involved_users()->sync($executorsAndOrderer);
        event(new TaskWasAccepted($notification));
        session()->flash('flash_success', 'Úloha bola označená ako schválená');
        return redirect()->back();
    }

    public function reject(Task $task, Request $request)
    {
        if (Gate::denies('determine', $task)) {
            return $this->unauthorizedResponse($request);
        }
        $task->confirmed = 0;
        $task->accomplish_date = null;
        $task->save();
        $notification = Notification::create(['type' => 'Úloha navrátená', 'user_id' => Auth::user()->id, 'task_id' => $task->id]);
        $executorsAndOrderer = $task->executors->lists('id')->toArray();
        array_push($executorsAndOrderer, $task->orderer->id);
        $notification->involved_users()->sync($executorsAndOrderer);
        event(new TaskWasRejected($notification));
        session()->flash('flash_success', 'Úloha bola navrátená');
        return redirect()->back();
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
        if ($request->ajax()) {
            return new Response('Nemáte oprávnenia prezerať túto úlohu', 403);
        }

        return new Response(view('errors.403'), 403);
    }

    public function resetFilter(Request $request)
    {
        if ($request->session()->has('filters')) {
            $request->session()->forget('filters');
        }
        return redirect('tasks');
    }

}
