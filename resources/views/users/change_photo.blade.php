@extends('layout')
@section('content')
    @include('partials.validation_errors')
    {!! Form::open(['action' => 'UsersController@uploadPhoto', 'files' => 'true']) !!}
    <div class="form-group">
        {!! Form::label('photo', 'Fotka') !!}
        {!! Form::file('photo', ['id' => 'photo']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Nahrať fotku', ['class' => 'btn btn-primary form-control']) !!}
    </div>
    {!! Form::close() !!}
@endsection