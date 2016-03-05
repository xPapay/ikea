@extends('layout')
@section('content')
    @include('partials.dropdown_status')
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
        @foreach($issues as $issue)
            <tr>
                <th></th>
                <td>
                    <a href="{{ action('IssuesController@show', ['id' => $issue->id]) }}">
                        {{ $issue->name }}
                    </a>
                </td>
                <td>
                    {{ $issue->deadline }}
                </td>
                <td>
                    {{ $issue->orderer->name }}
                </td>
                <td>
                    @if (! is_null($issue->accomplish_date))
                        {{ $issue->accomplish_date }}
                    @else
                        <span class="glyphicon glyphicon-remove-sign"></span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection