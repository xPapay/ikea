@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>{{ $issue->name }}</h1>
        </div>
        <hr>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <h4>Popis</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <p>{{ $issue->description }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <h4>Riešenie</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <p>{{ $issue->solution }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <h4>Zadávateľ úlohy:</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            {{ $issue->reporter->name }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <h4>Termín úlohy:</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            {{ $issue->deadline }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h4>Zodpovedný za vykonanie:</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @if (count($issue->executors) == 0)
                nešpecifikované
            @else
                <ul>
                    @foreach ($issue->executors as $executor)
                        <li>{{ $executor->name }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <h4>Termín followupu:</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            {{ $issue->followup_date }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-2">
            <h4>Followup vykoná:</h4>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            {{ $issue->followupBy->name }}
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            Úloha vytvorená: {{ Carbon\Carbon::parse($issue->created_at)->format('d. m. Y H:i') }}
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            @if ($issue->created_at != $issue->updated_at)
                Posledná úprava: {{ Carbon\Carbon::parse($issue->updated_at)->format('d. m. Y H:i') }}
            @endif
        </div>
    </div>


    <hr>

    <div id="comments">
        @foreach($issue->comments as $comment)
            @include('partials.comments')
        @endforeach

        @include('partials.create_comment', ['executable_id' => $issue->id, 'executable_type' => 'issue'])
    </div>
@endsection

@section('footer')
    <link rel="stylesheet" href="/css/comment.css">
@endsection