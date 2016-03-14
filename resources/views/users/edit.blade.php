@extends('layout')
@section('content')
    @include('partials.validation_errors')

    <h1>Upraviť užívateľa</h1>

    {!! Form::model($user, ['method' => 'PATCH', 'action' => ['UsersController@update', $user->id]]) !!}

    @include('users.form', ['submitButton' => 'Editovať užívateľa'])

    {!! Form::close() !!}
@endsection