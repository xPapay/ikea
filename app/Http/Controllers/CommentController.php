<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\FileUpload;
use App\Issue;
use App\Notification;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Http\Requests;
use App\Http\Requests\AddTaskRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Events\CommentAdded;

class CommentController extends Controller
{
    public function store(CommentRequest $request)
    {
        $comment = Comment::create($request->all());
        if ($request->input('executable_type') == 'task')
        {
            $task = Task::findOrFail($request->input('executable_id'));
            Auth::user()->makeComment($comment, $task);
            $fileUploader = new FileUpload($request->file('files'), $comment);
            $fileUploader->handleFilesUpload();

            $user_id = Auth::user()->id;
            $executorsAndOrderer = $task->executors()->lists('id')->toArray();
            array_push($executorsAndOrderer, $task->orderer->id);
            array_push($executorsAndOrderer, $user_id);
            $notification = Notification::create(['type' => 'Pridaný komentár', 'user_id' => $user_id, 'task_id' => $task->id]);
            $notification->involved_users()->sync($executorsAndOrderer);
            event(new CommentAdded($notification));
            session()->flash('flash_success', 'Komentár bol pridaný');

            return back();
        }

//        $issue = Issue::findOrFail($request->input('executable_id'));
//        Auth::user()->makeComment($comment, $issue);
        return redirect('issues/' . $request->input('executable_id'));
    }
}
