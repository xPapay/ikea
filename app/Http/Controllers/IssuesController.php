<?php

namespace App\Http\Controllers;

use App\Http\IssueStatus;
use App\Issue;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class IssuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status = 'unfinished')
    {
        $status = new IssueStatus($status);

        $tasks = Auth::user()->issues()->withStatus($status->getSelectedKey())->get();

        $selectedStatus = $status->getSelectedValue();
        $statusMenu = $status->getStatusMenu('issues/filter/');

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
        return view('issues.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Auth::user()->reportIssue(new Issue($request->all()), $request->executorsList);

        // TODO: flashing messages
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $issue = Issue::where('id', $request->issues)->firstOrFail();
        if (Gate::denies('show', $issue))
        {
            return $this->unauthorizedResponse($request);
        }


        return view('issues.show', compact('issue'));
    }

    public function showReported($status = 'unfinished')
    {
        $status = new IssueStatus($status);

        $issues = Auth::user()->reportedIssues()->withStatus($status->getSelectedKey())->with('executors')->get();

        $selectedStatus = $status->getSelectedValue();
        $statusMenu = $status->getStatusMenu('issues/reported/filter/');
        return view('issues.reported', compact('issues', 'selectedStatus', 'statusMenu'));
    }

    public function showAll(Request $request, $status = 'all')
    {
        if (!Auth::user()->isAdmin())
        {
            return $this->unauthorizedResponse($request);
        }
        $status = new IssueStatus($status);

        $issues = Issue::withStatus($status->getSelectedKey())->get();

        $selectedStatus = $status->getSelectedValue();
        $statusMenu = $status->getStatusMenu('admin/issues/');

        return view('issues.show_all', compact('issues', 'selectedStatus', 'statusMenu'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $issue = Issue::findOrFail($request->issues);

        if (Gate::denies('edit', $issue))
        {
            return $this->unauthorizedResponse($request);
        }

        $users = User::lists('name', 'id');
        return view('issues.edit', compact('issue', 'users'));
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
        //
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

    private function unauthorizedResponse(Request $request)
    {
        if ($request->ajax())
        {
            return new Response('Nemáte oprávnenia prezerať túto úlohu', 403);
        }

        return new Response(view('errors.403'), 403);
    }
}
