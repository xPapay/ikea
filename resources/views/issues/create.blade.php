@extends('layout')
@section('content')

    @include('partials.validation_errors')

    <h1>Zadať problém</h1>

    {!! Form::model(new \App\Issue(), ['action' => 'IssuesController@store']) !!}

    @include('issues.form', ['submitButton' => 'Zadať problém'])

    {!! Form::close() !!}

@endsection


