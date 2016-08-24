@extends('layout')
@section('content')
    <div class="page-header">
        <h1>Vaše úlohy</h1>
    </div>
    {!! Form::open(array('route' => 'my_tasks.filter', 'method' => 'GET')) !!}
        @include('partials.filterbox')
    {!! Form::close() !!}
    <a href="{{ route('reset_filter') }}" class="btn btn-default">Resetovať filter</a>
    <?php
        $now = \Carbon\Carbon::now();
    ?>
    @if (count($user_tasks) >= 1)
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
            @foreach($user_tasks as $user_task)
                @if($now->gt(\Carbon\Carbon::createFromFormat('d. m. Y', $user_task->task->deadline)))
                    <?php
                        $colour = 'danger';
                    ?>
                @elseif($now->diffInDays(\Carbon\Carbon::createFromFormat('d. m. Y', $user_task->task->deadline)) <= 14)
                    <?php
                        $colour = 'warning';
                    ?>
                @else
                    <?php
                        $colour = 'active';
                    ?>
                @endif
                <tr class="{{ $colour }}">
                    <th></th>
                    <td>
                        <a href="{{ action('TasksController@show', ['id' => $user_task->task->id, 'user_id' => $user_task->user_id]) }}">
                            {{ $user_task->task->name }}
                        </a>
                    </td>
                    <td>
                        {{ $user_task->task->deadline }}
                    </td>
                    <td>
                        @if($user_task->task->orderer)
                            {{ $user_task->task->orderer->name }}
                        @endif
                    </td>
                    <td>
                        @if($user_task->confirmed == 1)
                            {{ $user_task->accomplish_date }}
                        @elseif(($user_task->confirmed == 0) && ($user_task->accomplish_date != null))
                            <span class="glyphicon glyphicon-time"></span>
                        @else
                            <a href="{{url('tasks/accomplish', [$user_task->task->id, Auth::user()->id])}}" class="btn btn-success btn-sm">Dokončiť</a>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="row">
            <div class="col-lg-12">
                {!! $user_tasks->render() !!}
            </div>
        </div>
    @endif
@endsection