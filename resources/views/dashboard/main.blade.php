@extends('layout')
@section('content')
<?php
    $now = \Carbon\Carbon::now();
?>
    <div class="row">
        <div class="col-sm-3">
            @include('dashboard.partials.user')
        </div>

        <div class="col-xs-1"></div>

        <div class="col-sm-8">
            @include('dashboard.partials.notifications')
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12"></div>
    </div>

    <div class="row" id="second_row">
        <div class="col-sm-12" id="tasks_list">
            @include('dashboard.partials.tasks')
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12" id="supported_tasks_list">
            @include('dashboard.partials.supported')
        </div>
    </div>

@endsection