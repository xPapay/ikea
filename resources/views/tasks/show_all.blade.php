@extends('layout')
@section('content')
    <h1>Všetky úlohy</h1>
    {!! Form::open(array('route' => 'admin.tasks.filter')) !!}
        @include('partials.filterbox')
    {!! Form::close() !!}
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

    <div class="row">
        <div clas="col-lg-12">
            {!! $tasks->render() !!}
        </div>
    </div>
@endsection

@section('footer')
    <link href="/css/select2.css" rel="stylesheet" />
    <script src="/js/select2.js"></script>
    <script>
        $('#orderers').select2({
            placeholder: "Vyber zadávateľa"
        });

        $('#tags').select2({
            placeholder: "Vyber tagy"
        });
    </script>

    <link href="/css/bootstrap-datetimepicker.css" rel="stylesheet"/>
    <script src="/js/moment.js"></script>
    <script src="/js/bootstrap-datetimepicker.min.js"></script>

    <script>
        $(function () {
            $('#deadlineFrom').datetimepicker({
                locale: "sk",
                format: "DD. MM. YYYY",
                allowInputToggle: true,
                widgetPositioning: {
                    horizontal: 'left',
                    vertical: 'bottom'
                }
            }).on('dp.change', function (e) {
                $('#deadlineTo').data("DateTimePicker").minDate(e.date);
            })
            $('#deadlineTo').datetimepicker({
                locale: "sk",
                format: "DD. MM. YYYY",
                allowInputToggle: true,
                widgetPositioning: {
                    horizontal: 'left',
                    vertical: 'bottom'
                }
            })
        });
    </script>
@endsection