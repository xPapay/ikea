<div class="row">
    <div class="col-lg-12">
        <h4><a href="{{ action('TasksController@index') }}">Moje úlohy</a></h4>
        <hr>
    </div>
</div>

{{--<div class="row task" id="task_id-{{ $task->id }}">--}}

<table class="table table-hover">
    <thead>
    <tr>
        <th>#</th>
        <th>Typ</th>
        <th>Deadline</th>
        <th>Čo</th>
        <th>Status</th>
    </tr>
    </thead>

    <tbody>
    @foreach($tasks as $task)
        <tr>
            <th></th>
            <td>
                icon
            </td>
            <td>
                {{ $task->deadline }}
            </td>
            <td>
                <a href="{{ action('TasksController@show', ['id' => $task->id]) }}">
                    {{ $task->name }}
                </a>
            </td>
            <td>
                @if(!is_null($task->accomplish_date))
                    <span class="glyphicon glyphicon-time"></span>
                @else
                    <a href="{{url('tasks/accomplish', $task->id)}}"><span class="glyphicon glyphicon-remove-sign"></span></a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>


