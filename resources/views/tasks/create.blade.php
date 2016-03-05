@extends('layout')
@section('content')

    @include('partials.validation_errors')

    <h1>Zadať úlohu</h1>

    {!! Form::model(new \App\Task(), ['action' => 'TasksController@store']) !!}

        @include('tasks.form', ['submitButton' => 'Zadať úlohu'])

    {!! Form::close() !!}

@endsection
