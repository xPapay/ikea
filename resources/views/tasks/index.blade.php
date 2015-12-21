@extends('layout')
@section('content')
    <div class="page-header">
        <h1>Vaše úlohy</h1>
    </div>

    <div class="dropdown pull-right">
        <button class="btn btn-default dropdown-toggle" type="button" id="tasks_options" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            <span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="tasks_options">
            <li><a href="#">Nesplnené úlohy</a></li>
            <li><a href="#">Splnené úlohy</a></li>
            <li><a href="#">Všetky</a></li>
        </ul>
    </div>

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
            <?php $line_number = 0; ?>
            @foreach($tasks as $task)
                <?php $line_number++; ?>
                <tr>
                    <th>{{ $line_number }}</th>
                    <td>
                        {{ $task->name }}
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
    @endif
@endsection