@extends('layout')
@section('content')
    @include('partials.validation_errors')
    {!! Form::open(['action' => 'UsersController@updatePassword', 'method' => 'PATCH']) !!}
    <div class="form-group">
        {!! Form::label('password', 'Nové heslo') !!}
        {!! Form::password('password', ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('password_confirm', 'Heslo znova') !!}
        {!! Form::password('password_confirm', ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::submit('Ulož nové heslo', ['class' => 'btn btn-primary form-control']) !!}
    </div>
    {!! Form::close() !!}
@endsection