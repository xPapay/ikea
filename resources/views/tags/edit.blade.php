@extends('layout')
@section('content')
    @include('partials.validation_errors')

    <h1>Upraviť tag</h1>

    {!! Form::model($tag, ['method' => 'PATCH', 'action' => ['TagsController@update', $tag->id]]) !!}

        @include('tags.form', ['submitButton' => 'Editovať tag'])

    {!! Form::close() !!}
@endsection