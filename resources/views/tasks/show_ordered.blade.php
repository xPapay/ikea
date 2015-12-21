@extends('layout')
@section('content')
    <div class="page-header">
        <h1>Vami zadané úlohy</h1>
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
                <th>Vykoná</th>
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
                        @if (count($task->executors) == 0)
                            <i>nešpecifikované</i>
                        @elseif (count($task->executors) == 1)
                        {{ $task->executors[0]->name }}
                        @else
                            {{ $task->executors[0]->name }}
                            {{--<a href="{{ url("tasks/$task->id/executors") }}"><span class="glyphicon glyphicon-option-horizontal"></span></a>--}}
                            <span class="glyphicon glyphicon-option-horizontal more_executors" title="{!! $task->createTooltipster() !!}">

                            </span>
                        @endif

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
@section('footer')
    <link rel="stylesheet" type="text/css" href="/css/tooltipster/tooltipster.css" />
    <link rel="stylesheet" type="text/css" href="/css/tooltipster/tooltipster-shadow.css" />

    <script type="text/javascript" src="/js/jquery.tooltipster.js"></script>

    <script>
        $(document).ready(function() {
            $('.more_executors').tooltipster({
                contentAsHTML: true,
                theme: 'tooltipster-shadow',
                position: 'bottom'
            });
        });
    </script>
@endsection