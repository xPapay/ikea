@extends('layout')

@section('content')

    <div class="page-header">
        <h1>Vami zadané úlohy</h1>
        <i>{{ $selectedStatus }} úlohy</i>
    </div>

    <div class="dropdown pull-right">
        <button class="btn btn-default dropdown-toggle" type="button" id="tasks_options" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="true">
            {{ $selectedStatus }}
            {{--<span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>--}}
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="tasks_options">
            @foreach ($statusMenu as $path => $label)
                <li><a href="{{ url("tasks/ordered/{$path}") }}">{{ $label }}</a></li>
            @endforeach
        </ul>
    </div>

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
            </tr>

            </thead>

            <tbody>

            <?php
            $line_number = 0;
            ?>

            @foreach($tasks as $task)

                <?php
                $line_number++;
                $numberOfExecutors = count($task->executors);
                ?>

                <tr>
                    <th>{{ $line_number }}</th>
                    <td>
                        {{ $task->name }}
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
                                  title="{!! $task->createTooltipster() !!}">(+{{ $numberOfExecutors - 1 }})</span>
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