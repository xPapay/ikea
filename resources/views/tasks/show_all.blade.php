@extends('layout')
@section('content')
    <h1>Všetky úlohy</h1>
    {!! Form::open(array('route' => 'admin.tasks.filter', 'method' => 'GET')) !!}
        @include('partials.filterbox')
        <div class="row">
            <div class="col-lg-2">
                {!! Form::input('submit', 'excel', 'Exportuj do xls', ['class' => 'btn btn-success form-control']) !!}
            </div>
        </div>
    {!! Form::close() !!}
    <?php
        $now = \Carbon\Carbon::now();
    ?>
    <a href="{{ route('reset_filter') }}" class="btn btn-default">Resetovať filter</a>
<table class="table table-hover">
    <thead>
    <tr>
        <th>#</th>
        <th>Názov</th>
        <th>Deadline</th>
        <th>Zadal</th>
        <th>Vykoná</th>
        <th>Splnená dňa</th>
        <th>Akcia</th>
    </tr>
    </thead>
    <tbody>
    @foreach($tasks as $task)
        @if($now->gt(\Carbon\Carbon::createFromFormat('d. m. Y', $task->task->deadline)))
            <?php
                $colour = 'danger';
            ?>
        @elseif($now->diffInDays(\Carbon\Carbon::createFromFormat('d. m. Y', $task->task->deadline)) <= 14)
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
                <form action="{{ action('TasksController@show', ['id' => $task->id, 'user_id' => $task->user_id]) }}">
                    <input type="submit" value="{{ $task->task->name }}" />
                </form>
            </td>
            <td>
                {{ $task->task->deadline }}
            </td>
            <td>
            @if($task->task->orderer)
                {{ $task->task->orderer->name }}
            @endif
            </td>
            <td>
            @if($task->user->name)
                {{ $task->user->name }}
            @endif
            </td>
            <td>
                @if (! is_null($task->accomplish_date))
                    {{ $task->accomplish_date }}
                @else
                    <span class="glyphicon glyphicon-remove-sign"></span>
                @endif
            </td>
            <td>
                @can('edit', $task->task)
                <form action="{{ route("tasks.edit", ['id' => $task->task->id]) }}">
                    <input type="submit" value="Upraviť" />
                </form>
                {!! Form::open(['url' => "tasks/{$task->task_id}/{$task->user_id}", 'method'=>'delete']) !!}
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