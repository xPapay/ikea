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
                        <th>Akcia</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach ($user->roles as $role)
                                    <li>{{ $role->name }}</li>
                                @endforeach
                            </td>
                            <td><a href="{{ url("admin/users/{$user->id}/edit") }}"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td>
                                {!! Form::open(['route' => ['admin.users.change_status',$user->id], 'method'=>'POST']) !!}
                                {{ method_field('PUT') }}
                                @if ($user->active)
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        Deaktivovať
                                    </button>
                                @else
                                    <button type="submit" class="btn btn-success btn-sm">
                                        Aktivovať
                                    </button>
                                @endif
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                {!! $users->render() !!}
            </div>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary" role="button">Pridaj užívateľa</a>
        </div>
    </div>
@endsection