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
}
