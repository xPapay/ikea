@extends('layout')
@section('content')

    {!! Form::open(['action' => 'TasksController@store']) !!}
    <div class="form-group">
        {!! Form::label('name', 'Názov úlohy') !!}
        {!! Form::text('name', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('description', 'Popis') !!}
        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('deadline', 'Termín') !!}
        {!! Form::text('deadline', null, ['class' => 'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('executors', 'Priradený pracovníci') !!}
        {!! Form::select('executors[]', $users, null, ['class' => 'form-control', 'id' => 'executors_list', 'multiple']) !!}
    </div>

    <div class="form-group">
        {!! Form::submit('Zadať úlohu', ['class' => 'btn btn-primary form-control']) !!}
    </div>

@endsection

@section('footer')
    <link href="/css/select2.css" rel="stylesheet" />
    <script src="/js/select2.js"></script>
    <script>
        $('#executors_list').select2({
            placeholder: "Vyber pracovníkov"
        });
    </script>
@endsection