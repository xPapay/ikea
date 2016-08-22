<div class="row">
    <div class="col-lg-12">
        <h3><a href="{{ action('TasksController@showSupported') }}">Supportované úlohy</a></h3>
        <hr>
    </div>
</div>
<table class="table table-hover">
    <thead>
    <tr>
        <th>#</th>
        <th>Typ</th>
        <th>Deadline</th>
        <th>Čo</th>
    </tr>
    </thead>

    <tbody>
    @foreach($supported_tasks as $user_task)
        @if($now->gt(\Carbon\Carbon::createFromFormat('d. m. Y', $user_task->task->deadline)))
            <?php
                $colour = 'danger';
            ?>
        @elseif($now->diffInDays(\Carbon\Carbon::createFromFormat('d. m. Y', $user_task->task->deadline)) <= 14)
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
                {{ $user_task->task->deadline }}
            </td>
            <td>
                <a href="{{ action('TasksController@show', ['id' => $user_task->task->id]) }}">
                    {{ $user_task->task->name }}
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>