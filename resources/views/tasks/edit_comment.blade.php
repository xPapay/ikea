@extends('layout')
@section('content')

    @include('partials.validation_errors')

    <h1>Upraviť komentár</h1>

    {!! Form::model($comment, ['method' => 'PATCH', 'action' => ['TasksController@updateComment', $comment->id]]) !!}
    {!! Form::hidden('task_id', $task_id) !!}
        <div class="form-group">
            {!! Form::textarea('content', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-group">
            {!! Form::submit('Uprav komentár', ['class' => 'btn btn-primary form-control']) !!}
        </div>

    {!! Form::close() !!}

@endsection