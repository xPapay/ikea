@extends('layout')
@section('content')
    <div class="page-header">
        <h1>Vaše úlohy</h1>
        <i>{{ $selectedStatus }} úlohy</i>
    </div>

    @include('partials.dropdown_status')

    @if (count($tasks) == 0)
        <i>Nemáte žiadne nesplnené úlohy</i>
    @else
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
                        @if($task->confirmed == 1)
                            {{ $task->accomplish_date }}
                        @elseif(($task->confirmed == 0) && ($task->accomplish_date != null))
                            <span class="glyphicon glyphicon-time"></span>
                        @else
                            <a href="{{url('tasks/accomplish', $task->id)}}"><span class="glyphicon glyphicon-remove-sign"></span></a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="row">
            <div class="col-lg-12">
                {!! $tasks->render() !!}
            </div>
        </div>
    @endif
@endsection