@extends('layout')

@section('content')

    <div class="page-header">
        <h1>Vami zadané úlohy</h1>
        <i>{{ $selectedStatus }} úlohy</i>
    </div>

    @include('partials.dropdown_status')

    @if (count($tasks) == 0)
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
                    @if ($selectedStatus != "dokončené")
                        <th>Akcia</th>
                    @endif
                    <th>Editovanie</th>
                </tr>
            </thead>

            <tbody>
            @foreach($tasks as $task)
                <?php
                $numberOfExecutors = count($task->executors);
                ?>
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
                        @if ($numberOfExecutors == 0)
                            <i>nešpecifikované</i>
                        @elseif ($numberOfExecutors == 1)
                        {{ $task->executors[0]->name }}
                        @else
                            {{ $task->executors[0]->name }}
                            <span class="more_executors"
                                  title="{!! $task->createTooltipster() !!}"><i>(+{{ $numberOfExecutors - 1 }})</i></span>
                        @endif
                    </td>
                    <td>
                        @if (! is_null($task->accomplish_date))
                            {{ $task->accomplish_date }}
                        @else
                            <span class="glyphicon glyphicon-remove-sign"></span>
                        @endif
                    </td>
                    @if ($selectedStatus != "dokončené")
                        <td>
                            @if (($task->accomplish_date != null) && ($task->confirmed != 1))
                                <a href="{{ url("tasks/accept/{$task->id}") }}"><span class="glyphicon glyphicon-ok"></span></a>
                                <a href="{{ url("tasks/reject/{$task->id}") }}"><span class="glyphicon glyphicon-remove"></span></a>
                            @endif
                        </td>
                    @endif
                    <td>
                         <a href="{{ url("tasks/{$task->id}/edit") }}">Upraviť</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endif

    <div class="row">
        <div class="col-lg-12">
            <a href="{{ url('tasks/create') }}" class="btn btn-primary" role="button">Zadať úlohu</a>
        </div>
    </div>
@endsection

@section('footer')

    @include('partials.tooltipster')

@endsection