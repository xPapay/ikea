@extends('layout')
@section('content')
    <h2>Users:</h2>

    @if (!empty($users))
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Meno</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Editovať</th>
                        <th>Zmazať</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <li>{{ $role->name }}</li>
                                @endforeach
                            </td>
                            <td><a href="{{ url("admin/users/{$user->id}/edit") }}"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td>
                                {!! Form::open(['route' => ['admin.users.destroy',$user->id], 'method'=>'delete']) !!}
                                <button type="submit" class="btn btn-default btn-sm">
                                    <span class="glyphicon glyphicon-remove-sign"></span>
                                </button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    @endif
@endsection