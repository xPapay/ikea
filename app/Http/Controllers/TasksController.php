<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\ShowTaskRequest;
use App\Http\SimpleImage;
use App\Http\TaskFilter;
use App\Http\TaskStatus;
use App\Tag;
use App\Task;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use Intervention\Image\Facades\Image;

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
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'deadline' => 'required|date_format:d. m. Y',
            'executorsList' => 'required',
        ];

        $files = $request->file( 'files' );

        if ( !empty( $files ) ) {
            foreach ($files as $key => $file) // add individual rules to each image
            {
                $rules[sprintf('files.%d', $key)] = 'max:2000';
            }
        }

        $this->validate($request, $rules);

        $task = Auth::user()->orderTask(new Task($request->all()), $request->executorsList, $request->tagsList);

        foreach ($files as $file)
        {
            if (substr($file->getMimeType(), 0, 5) == 'image')
            {
                $name = time() . $file->getClientOriginalName();
                $path = 'upload/' . $name;
                $thumbnail_path = 'upload/_tn' . $name;

//                $image = new SimpleImage($file->getPathName());
//                $image->resizeDownToWidth(800);
//                $image->save($path, $image->image_type, 90, 0755);

                $image = Image::make($file->getPathName());
                $image->resize(1024, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $image->save($path);

                $thumbnail = Image::make($file->getPathName());
                $thumbnail->fit(200)->save($thumbnail_path);

                $task->photos()->create(['path' => $path, 'thumbnail_path' => $thumbnail_path]);
            }
        }
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

        $tasks = $tasks_query->paginate(10)->appends(Input::except('page'));
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
    public function update(Request $request, Task $task)
    {
        $task->update($request->all());
        $task->assignToUsers($request->input('executorsList'));
        $task->assignTag($request->input('tagsList'));

        return redirect('tasks/' . $task->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function accomplish(Task $task, Request $request)
    {
        if (Gate::denies('accomplish', $task)) {
            return $this->unauthorizedResponse($request);
        }
        $task->accomplish_date = Carbon::now();
        $task->save();
        return redirect()->back();
    }

    public function accept(Task $task, Request $request)
    {
        if (Gate::denies('determine', $task)) {
            return $this->unauthorizedResponse($request);
        }
        $task->confirmed = 1;
        $task->save();
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

}
