@extends('layout')
@section('content')

    @include('partials.validation_errors')

    <h1>Upraviť problém</h1>

    {!! Form::model($issue, ['method' => 'PATCH', 'action' => ['IssuesController@update', $issue->id]]) !!}

    @include('issues.form', ['submitButton' => 'Editovať problém'])

    {!! Form::close() !!}

@endsection
