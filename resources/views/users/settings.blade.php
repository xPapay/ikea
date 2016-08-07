@extends('layout')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3><a href="{{ action('UsersController@editPassword') }}">Zmena hesla</a></h3>
        <h3><a href="{{ action('UsersController@editNotifications') }}">Nastavenie notifikácií</a></h3>
    </div>
</div>
@endsection