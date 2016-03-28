<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Http\FileUpload;
use App\Issue;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Http\Requests;
use App\Http\Requests\AddTaskRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
            return redirect('tasks/' . $request->input('executable_id'));
        }

//        $issue = Issue::findOrFail($request->input('executable_id'));
//        Auth::user()->makeComment($comment, $issue);
        return redirect('issues/' . $request->input('executable_id'));
    }
}
