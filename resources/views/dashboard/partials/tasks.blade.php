<div class="row">
    <div class="col-lg-12">
        <h4><a href="{{ action('TasksController@index') }}" class="btn btn-primary" role="button">Moje úlohy</a></h4>
        <hr>
    </div>
</div>

{{--<div class="row task" id="task_id-{{ $task->id }}">--}}
{{ $now = \Carbon\Carbon::now() }}
{{ $future = \Carbon\Carbon::createFromFormat('d. m. Y', '12. 07. 2016') }}
{{ $now->gt($future) ? 'ano' : 'nie' }}
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
        @if($now->gt(\Carbon\Carbon::createFromFormat('d. m. Y', $task->deadline)))
            <?php
                $colour = 'danger';
            ?>
        @elseif($now->diffInDays(\Carbon\Carbon::createFromFormat('d. m. Y', $task->deadline)) <= 14)
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
                    <a href="{{url('tasks/accomplish', $task->id)}}" class="btn btn-success btn-sm">Dokončiť</a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table>


