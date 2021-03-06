@extends('layout')
@section('content')
    <div class="row">
        <div class="col-lg-5">
            <div class="row">
                <div class="col-lg-12">
                    <h1>{{ $task->name }}</h1>
                </div>
                <hr>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h4>Popis</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <p>{{ $task->description }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h4>Zadávateľ úlohy:</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                @if($task->orderer)
                    {{ $task->orderer->name }}
                @endif
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h4>Termín úlohy:</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    {{ $task->deadline }}
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h4>Zodpovedný za vykonanie:</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    @if (count($task->executors) == 0)
                        nešpecifikované
                    @else
                        <ul>
                            @foreach ($task->executors as $executor)
                                <li>{{ $executor->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h4>Supportujúci pracovníci:</h4>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    @if (count($task->supporters) == 0)
                        nešpecifikované
                    @else
                        <ul>
                            @foreach ($task->supporters as $supporter)
                                <li>{{ $supporter->name }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <h4>Tagy:</h4>
                    <ul>
                        @foreach ($task->tags as $tag)
                            <li>{{ $tag->name }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    Úloha vytvorená: {{ Carbon\Carbon::parse($task->created_at)->format('d. m. Y H:i') }}
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    @if ($task->created_at != $task->updated_at)
                        Posledná úprava: {{ Carbon\Carbon::parse($task->updated_at)->format('d. m. Y H:i') }}
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            @if (count($task->photos) > 0)
                <h4>Fotky:</h4>
                @foreach($task->photos->chunk(3) as $row)
                    <div class="row>">
                        @foreach($row as $photo)
                            <div class="col-lg-4">
                                <a href="/{{ $photo->path }}" data-lity>
                                    <img src="/{{ $photo->thumbnail_path }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            @if (count($task->files) > 0)
                <h4>Subory:</h4>
                @foreach($task->files->chunk(3) as $row)
                    <div class="row>">
                        @foreach($row as $file)
                            <div class="col-lg-4">
                                <a href="{{ asset($file->path) }}">
                                    {{ substr($file->name, 11) }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
        <!-- TODO: Refactor -->
            @if($task->confirmed == 1)
                Splnená dňa: {{ \Carbon\Carbon::parse($task->accomplish_date)->format('d. m. Y') }}
            @elseif(($task->confirmed == 0) && ($task->accomplish_date != null))
                @if($task->orderer->id == Auth::user()->id)
                    <a href="{{ url("tasks/accept/{$task->id}/{$task->user_id}") }}"><span class="glyphicon glyphicon-ok"></span></a>
                    <a href="{{ url("tasks/reject/{$task->id}/{$task->user_id}") }}"><span class="glyphicon glyphicon-remove"></span></a>
                @else
                    <span class="glyphicon glyphicon-time"></span>
                @endif
            @else
                @can('accomplish', $task)
                    <a href="{{url('tasks/accomplish', [$task->id, Auth::user()->id])}}" class="btn btn-success btn-sm">Dokončiť</a>
                @endcan
            @endif
        </div>
    </div>
    @can('edit', $task)
        <div class="row">
            <div class="col-lg-12">
                <a href="{{ route("tasks.edit", ['id' => $task->id]) }}" class="btn btn-default btn-sm">Upraviť</a>
            </div>
        </div>
    @endcan

    <hr>

    <div id="comments">
        <h3>Komentáre:</h3>
        @foreach($task->comments as $comment)
            @include('partials.comments')
        @endforeach

        @include('partials.create_comment', ['executable_id' => $task->id, 'executable_type' => 'task'])
    </div>
@endsection

@section('footer')
    <link rel="stylesheet" href="/css/comment.css">
@endsection