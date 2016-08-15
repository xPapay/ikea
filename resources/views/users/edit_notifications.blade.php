@extends('layout')
@section('head')
<script>
    function show_value(name, x)
    {
        document.getElementById(name + '_value').innerHTML=x + ":00h";
    }

    function initialSlidersValues() 
    {
        var firstSlider = document.getElementById('no_interruption_from');
        var secondSlider = document.getElementById('no_interruption_to');
        show_value(firstSlider.name, firstSlider.value);
        show_value(secondSlider.name, secondSlider.value);
    }

    window.onload = initialSlidersValues;
</script>
@endsection
@section('content')
<h3>Notifikovať o: </h3>
</hr>
    @include('partials.validation_errors')
    {!! Form::model($user, ['action' => 'UsersController@updateNotifications', 'method' => 'PATCH']) !!}
    <div class="form-group">
        {!! Form::label('notify_task_assigned', 'Pridelení na úlohu') !!}
        {!! Form::checkbox('notify_task_assigned', 1) !!}
    </div>
    <div class="form-group">
        {!! Form::label('notify_task_unassigned', 'Odobratí z vykonania úlohy') !!}
        {!! Form::checkbox('notify_task_unassigned', 1) !!}
    </div>
    <div class="form-group">
        {!! Form::label('notify_task_edited', 'Editovaní úlohy') !!}
        {!! Form::checkbox('notify_task_edited', 1) !!}
    </div>
    <div class="form-group">
        {!! Form::label('notify_task_deleted', 'Zmazaní úlohy') !!}
        {!! Form::checkbox('notify_task_deleted', 1) !!}
    </div>
    <div class="form-group">
        {!! Form::label('notify_task_accomplished', 'Dokončení úlohy') !!}
        {!! Form::checkbox('notify_task_accomplished', 1) !!}
    </div>
    <div class="form-group">
        {!! Form::label('notify_task_accepted', 'Schválení úlohy') !!}
        {!! Form::checkbox('notify_task_accepted', 1) !!}
    </div>
    <div class="form-group">
        {!! Form::label('notify_task_rejected', 'Neschválení úlohy') !!}
        {!! Form::checkbox('notify_task_rejected', 1) !!}
    </div>
    <div class="form-group">
        {!! Form::label('notify_comment_added', 'Pridaní komentára') !!}
        {!! Form::checkbox('notify_comment_added', 1) !!}
    </div>
    <div class="form-group">
        {!! Form::label('notify_task_before_deadline', 'Blížiacom sa dedlajne') !!}
        {!! Form::checkbox('notify_task_before_deadline', 1) !!}
    </div>
    </br>
    <hr>
    <div class="row">
    <h3>Stíšenie notifikácií</h3>
        <div class="col-md-4">
        {!! Form::label('no_interruption_from', 'Od') !!}
        <span id="no_interruption_from_value" style="color:red;"></span>
        <input type="range" name="no_interruption_from" id="no_interruption_from" min="0" max="23" step="1" onchange="show_value(this.id, this.value);" value='{{ $user->no_interruption_from }}'>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
        {!! Form::label('no_interruption_to', 'Do') !!}
        <span id="no_interruption_to_value" style="color:red;"></span>
        <input type="range" name="no_interruption_to" id="no_interruption_to" min="0" max="23" step="1" onchange="show_value(this.id, this.value);" value='{{ $user->no_interruption_to }}'>
        </div>
    </div>
    <div class="form-group">
    {!! Form::submit("Nastaviť", ['class' => 'btn btn-primary form-control']) !!}
    </div>
    {!! Form::close() !!}
@endsection