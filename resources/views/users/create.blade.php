@extends('layout')
@section('content')
    @include('partials.validation_errors')

    <h1>Vytvoriť užívateľa</h1>

    {!! Form::model(new \App\User(), ['action' => 'UsersController@store']) !!}

        @include('users.form', ['submitButton' => 'Vytvoriť užívateľa'])

    {!! Form::close() !!}
@endsection