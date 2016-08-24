@extends('layout')
@section('content')
    <div class="page-header">
        <h1>Vami zadané úlohy</h1>
    </div>
    {!! Form::open(array('route' => 'ordered_tasks.filter', 'method' => 'GET')) !!}
        @include('partials.filterbox')
        <div class="row">
            <div class="col-lg-2">
                {!! Form::input('submit', 'excel', 'Exportuj do xls', ['class' => 'btn btn-success form-control']) !!}
            </div>
        </div>
    {!! Form::close() !!}
    <a href="{{ route('reset_filter') }}" class="btn btn-default">Resetovať filter</a>
    <?php
        $now = \Carbon\Carbon::now();
    ?>
    @if (count($tasks_users) == 0)
        <i>Nenašli sa žiadne úlohy</i>
    @else
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Názov</th>
                    <th>Deadline</th>
                    <th>Vykoná</th>
                    <th>Splnená dňa</th>
                    @if ($filters['status'] != "finished")
                        <th>Akcia</th>
                    @endif
                    <th>Editovanie</th>
                </tr>
            </thead>

            <tbody>
            @foreach($tasks_users as $task_user)
                <?php
                $numberOfExecutors = count($task_user->task->executors);
                ?>
                @if($now->gt(\Carbon\Carbon::createFromFormat('d. m. Y', $task_user->task->deadline)))
                    <?php
                        $colour = 'danger';
                    ?>
                @elseif($now->diffInDays(\Carbon\Carbon::createFromFormat('d. m. Y', $task_user->task->deadline)) <= 14)
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
                        <a href="{{ action('TasksController@show', ['id' => $task_user->task->id, 'user_id' => $task_user->user_id]) }}">
                            {{ $task_user->task->name }}
                        </a>
                    </td>
                    <td>
                        {{ $task_user->task->deadline }}
                    </td>
                    <td>
                        {{ $task_user->user->name }}
                    </td>
                    <td>
                        @if (! is_null($task_user->accomplish_date))
                            {{ $task_user->accomplish_date }}
                        @else
                            <span class="glyphicon glyphicon-remove-sign"></span>
                        @endif
                    </td>
                    @if ($filters['status'] != "finished")
                        <td>
                            @if (($task_user->accomplish_date != null) && ($task_user->confirmed != 1))
                                <a href="{{ url("tasks/accept/{$task_user->task_id}/{$task_user->user_id}") }}"><span class="glyphicon glyphicon-ok"></span></a>
                                <a href="{{ url("tasks/reject/{$task_user->task_id}/{$task_user->user_id}") }}"><span class="glyphicon glyphicon-remove"></span></a>
                            @endif
                        </td>
                    @endif
                    <td>
                        <a href="{{ route("tasks.edit", ['id' => $task_user->task->id]) }}" class="btn btn-default btn-sm">Upraviť</a>
                        {!! Form::open(['url' => "tasks/{$task_user->task_id}/{$task_user->user_id}", 'method'=>'delete']) !!}
                        <button type="submit" class="btn btn-danger btn-sm">
                            Zmazať
                        </button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endif

    <div class="row">
        <div class="col-lg-12">
            {!! $tasks_users->render() !!}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <a href="{{ url('tasks/create') }}" class="btn btn-primary" role="button">Zadať úlohu</a>
        </div>
    </div>
@endsection

@section('footer')

    @include('partials.tooltipster')

@endsection