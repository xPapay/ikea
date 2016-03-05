@extends('layout')

@section('content')

    <div class="page-header">
        <h1>Vami zadané problémy</h1>
        <i>{{ $selectedStatus }} problémy</i>
    </div>

    @include('partials.dropdown_status')

    @if (count($issues) == 0)
        <i>Nie sú zaevidované žiadne problémy</i>
    @else
        <table class="table table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Názov</th>
                <th>Deadline</th>
                <th>Vykoná</th>
                <th>Termín followupu</th>
                <th>Followup vykoná</th>
                <th>Vyriešený dňa</th>
                <th></th>
            </tr>
            </thead>

            <tbody>
            @foreach($issues as $issue)
                <?php
                $numberOfExecutors = count($issue->executors);
                ?>
                <tr>
                    <th></th>
                    <td>
                        <a href="{{ action('TasksController@show', ['id' => $issue->id]) }}">
                            {{ $issue->name }}
                        </a>
                    </td>
                    <td>
                        {{ $issue->deadline }}
                    </td>
                    <td>
                        @if ($numberOfExecutors == 0)
                            <i>nešpecifikované</i>
                        @elseif ($numberOfExecutors == 1)
                            {{ $issue->executors[0]->name }}
                        @else
                            {{ $issue->executors[0]->name }}
                            <span class="more_executors"
                                  title="{!! $issue->createTooltipster() !!}"><i>(+{{ $numberOfExecutors - 1 }})</i></span>
                        @endif
                    </td>
                    <td>
                        {{ $issue->followup_date }}
                    </td>
                    <td>
                        {{ $issue->followupBy->name }}
                    </td>
                    <td>
                        @if (! is_null($issue->accomplish_date))
                            {{ $issue->accomplish_date }}
                        @else
                            <span class="glyphicon glyphicon-remove-sign"></span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ url("issues/{$issue->id}/edit") }}">Upraviť</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endif
@endsection

@section('footer')

    @include('partials.tooltipster')

@endsection