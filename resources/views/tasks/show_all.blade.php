@extends('layout')
@section('content')
    @include('partials.dropdown_status')
<table class="table table-hover">
    <thead>
    <tr>
        <th>#</th>
        <th>Názov</th>
        <th>Deadline</th>
        <th>Zadal</th>
        <th>Splnená dňa</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tasks as $task)
        <tr>
            <th></th>
            <td>
                <a href="{{ action('TasksController@show', ['id' => $task->id]) }}">
                    {{ $task->name }}
                </a>
            </td>
            <td>
                {{ $task->deadline }}
            </td>
            <td>
                {{ $task->orderer->name }}
            </td>
            <td>
                @if (! is_null($task->accomplish_date))
                    {{ $task->accomplish_date }}
                @else
                    <span class="glyphicon glyphicon-remove-sign"></span>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>

    <div class="row">
        <div clas="col-lg-12">
            {!! $tasks->render() !!}
        </div>
    </div>
@endsection