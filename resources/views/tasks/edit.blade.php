@extends('layout')
@section('content')

    @include('partials.validation_errors')

    <h1>Upraviť úlohu</h1>

    {!! Form::model($task, ['method' => 'PATCH', 'action' => ['TasksController@update', $task->id]]) !!}

        @include('tasks.form', ['submitButton' => 'Editovať úlohu'])

    {!! Form::close() !!}

@endsection
