@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $task->name }}</h1>
        </div>
        <div class="col-md-4">
            <h3>countdown</h3>
        </div>
        <hr>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <h4>Popis</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <p>{{ $task->description }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <h4>Zadávateľ úlohy:</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            {{ $task->orderer->name }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <h4>Termín úlohy:</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            {{ $task->deadline }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4>Zodpovedný za vykonanie:</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if (count($task->executors) == 0)
                nešpecifikované
            @else
                <ul>
                    @foreach ($task->executors as $executor)
                        <li>{{ $executor->name }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <hr>

    <div id="comments">
        @include('tasks.partials.comments')
    </div>
@endsection

@section('footer')
    <link rel="stylesheet" href="/css/comment.css">
@endsection