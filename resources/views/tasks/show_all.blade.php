@extends('layout')
@section('content')
    <h1>Všetky úlohy</h1>
    {!! Form::open(array('route' => 'admin.tasks.filter', 'method' => 'GET')) !!}
        @include('partials.filterbox')
    {!! Form::close() !!}
<table class="table table-hover">
    <thead>
    <tr>
        <th>#</th>
        <th>Názov</th>
        <th>Deadline</th>
        <th>Zadal</th>
        <th>Splnená dňa</th>
        <th>Akcia</th>
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
            <td>
                @can('edit', $task)
                <a href="{{ route("tasks.edit", ['id' => $task->id]) }}" class="btn btn-default btn-sm">Upraviť</a>
                {!! Form::open(['route' => ['tasks.destroy',$task->id], 'method'=>'delete']) !!}
                <button type="submit" class="btn btn-danger btn-sm">
                    Zmazať
                </button>
                {!! Form::close() !!}
                @endcan
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