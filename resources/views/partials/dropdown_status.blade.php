<div class="dropdown pull-right">
    <button class="btn btn-default dropdown-toggle" type="button" id="tasks_options" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="true">
        {{ $selectedStatus }}
        {{--<span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span>--}}
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="tasks_options">
        @foreach ($statusMenu as $path => $label)
            <li><a href="/{{ $path }}">{{ $label }}</a></li>

        @endforeach
    </ul>
</div>
