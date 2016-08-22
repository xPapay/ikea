@extends('layout')
@section('content')
    <div class="page-header">
        <h1>Supportované úlohy</h1>
        {!! Form::open(array('route' => 'my_supported_tasks.filter', 'method' => 'GET')) !!}
            @include('partials.filterbox', array('do_not_show_status' => 'true'))
        {!! Form::close() !!}
    <a href="{{ route('reset_filter') }}" class="btn btn-default">Resetovať filter</a>
    </div>
    @if (count($supported_tasks) >= 1)
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Názov</th>
                    <th>Deadline</th>
                    <th>Zadal</th>
                </tr>
            </thead>
            <tbody>
            @foreach($supported_tasks as $task)
                <tr>
                    <th></th>
                    <td>
                        <a href="{{ action('TasksController@show', ['id' => $task->id]) }}">
                            {{ $task->name }}
                        </a>
                    </td>
                    <td>
                        {{ $task->task->deadline }}
                    </td>
                    <td>
                        @if($task->task->orderer)
                            {{ $task->task->orderer->name }}
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="row">
            <div class="col-lg-12">
                {!! $supported_tasks->render() !!}
            </div>
        </div>
    @endif
@endsection