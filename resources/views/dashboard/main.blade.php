@extends('layout')
@section('content')
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
        <div class="col-sm-6" id="tasks_list">
            @include('dashboard.partials.tasks')
        </div>


        <div class="col-sm-6">
            @include('dashboard.partials.details')
        </div>
    </div>

@endsection