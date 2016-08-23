<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('name')->with('roles')->paginate(20);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::lists('name', 'id');
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|unique:users'
        ]);
        $user = User::create($request->all());
        $user->addRole($request->rolesList);
        session()->flash('flash_success', 'Užívateľ bol úspešne pridaný');
        return redirect('admin/users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::lists('name', 'id');
        return view('users.edit', compact('user', 'roles'));
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
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|required'
        ]);
        $user = User::where('id', $id)->first();
        $user->update($request->all());
        $user->assignRole($request->rolesList);
        session()->flash('flash_success', 'Užívateľ bol úspešne editovaný');
        return redirect('admin/users');
    }

    public function changeStatus($id)
    {
        $user = User::where('id', $id)->first();
        if ($user->active == 1)
        {
            $user->active = 0;
            $user->save();
            session()->flash('flash_success', 'Užívateľské konto bolo deaktivované');
            return redirect('admin/users');
        }
        $user->active = 1;
        $user->save();
        session()->flash('flash_success', 'Užívateľské konto bolo aktivované');
        return redirect('admin/users');
    }

    public function activate($id)
    {
        $user = User::where('id', $id)->first();
        $user->active = 0;
        $user->save();
        session()->flash('flash_success', 'Užívateľské konto bolo deaktivované');
        return redirect('admin/users');
    }

    public function editPassword()
    {
        return view('users.edit_password');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|min:6',
            'password_confirm' => 'required|same:password',
        ]);
        $user = Auth::user();
        $user->update(['password' => bcrypt($request->get('password'))]);
        session()->flash('flash_success', 'Heslo bolo úspešne zmenené');
        return redirect('/');
    }

    public function resetPassword(User $user)
    {
        $user->password = bcrypt('123456');
        $user->save();
        session()->flash('flash_success', 'Heslo bolo zresetované');
        return back();
    }

    public function editNotifications()
    {
        $user = Auth::user();
        return view('users.edit_notifications', compact('user'));
    }

    public function updateNotifications(Request $request)
    {
        $this->validate($request, [
            'notify_task_assigned' => 'boolean',
            'notify_task_unassigned' => 'boolean',
            'notify_task_edited' => 'boolean',
            'notify_task_deleted' => 'boolean',
            'notify_task_accomplished' => 'boolean',
            'notify_task_accepted' => 'boolean',
            'notify_task_rejected' => 'boolean',
            'notify_comment_added' => 'boolean',
            'notify_task_before_deadline' => 'boolean',
            'no_interruption_from' => 'min:0|max:23',
            'no_interruption_to' => 'min:0|max:23'
        ]);
        $user = Auth::user();
        $user->update(
            [
            'notify_task_assigned' => $request->input('notify_task_assigned', false),
            'notify_task_unassigned' => $request->input('notify_task_unassigned', false),
            'notify_task_assigned' => $request->input('notify_task_assigned', false),
            'notify_task_edited' => $request->input('notify_task_edited', false),
            'notify_task_deleted' => $request->input('notify_task_deleted', false),
            'notify_task_accomplished' => $request->input('notify_task_accomplished', false),
            'notify_task_accepted' => $request->input('notify_task_accepted', false),
            'notify_task_rejected' => $request->input('notify_task_rejected', false),
            'notify_comment_added' => $request->input('notify_comment_added', false),
            'notify_task_before_deadline' => $request->input('notify_task_before_deadline', false),
            'no_interruption_from' => $request->input('no_interruption_from', 0),
            'no_interruption_to' => $request->input('no_interruption_to', 0)
            ]
        );
        session()->flash('flash_success', 'Nastavenia notifikácií boli aplikované');
        return redirect()->back();
    }

    public function showSettings()
    {
        return view('users.settings');
    }
}
